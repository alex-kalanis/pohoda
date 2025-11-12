<?php

namespace Riesenia\Pohoda\Common\Dtos;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use ReflectionUnionType;
use Riesenia\Pohoda\Common\Attributes;

class Processing
{
    /**
     * Throw out the entries that cannot be used for check - containing null or empty array
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function filterUnusableData(array $data): array
    {
        // throw nulls and empty arrays (unused values) out
        return array_filter(
            $data,
            fn($in) => !(is_null($in) || (is_array($in) && empty($in)))
        );
    }

    /**
     * Get all referenced attributes from DTOs
     *
     * @param AbstractDto $class
     * @param bool $responseDirection
     *
     * @return string[]
     */
    public static function getRefAttributes(AbstractDto $class, bool $responseDirection): array
    {
        $reflection = new ReflectionClass($class);
        $allProperties = $reflection->getProperties();
        $ref = [];
        foreach ($allProperties as $property) {
            if (static::hasSkipAttribute($property)) {
                continue;
            }
            if (static::hasDirectionAttribute($property) && !$responseDirection) {
                continue;
            }
            if (static::hasRefAttribute($property)) {
                $ref[] = $property->getName();
            }
        }
        return $ref;
    }

    /**
     * Get all properties of DTO
     *
     * @param AbstractDto $class
     * @param bool $withAttributes
     * @param bool $responseDirection
     *
     * @return string[]
     */
    public static function getProperties(AbstractDto $class, bool $withAttributes, bool $responseDirection): array
    {
        $reflection = new \ReflectionClass($class);
        $props = [];
        foreach ($reflection->getProperties() as $prop) {
            if (static::hasSkipAttribute($prop)) {
                continue;
            }
            if (static::hasDirectionAttribute($prop) && !$responseDirection) {
                continue;
            }
            if (static::isJustAttribute($prop) && !$withAttributes) {
                continue;
            }
            $props[] = $prop->getName();
        }
        return $props;
    }

    /**
     * Fill DTO with data, change types when necessary
     *
     * @param AbstractDto $class
     * @param array<string, mixed> $data
     * @param bool $responseDirection
     *
     * @throws ReflectionException
     *
     * @return AbstractDto
     */
    public static function hydrate(AbstractDto $class, array $data, bool $responseDirection): AbstractDto
    {
        $reflection = new ReflectionClass($class);
        $clonedInstance = $reflection->newInstance();
        $usedKeys = [];
        // regular defined properties
        $allProperties = $reflection->getProperties();
        foreach ($allProperties as $property) {
            if (static::hasSkipAttribute($property)) {
                continue;
            }
            if (static::hasDirectionAttribute($property) && !$responseDirection) {
                continue;
            }

            $key = static::getRepresentsAttribute($property) ?? $property->getName();
            if (isset($data[$key])) {
                $value = $data[$key];
                $propertyType = static::getPropertyType($property, $value);

                if (!empty($propertyType)) {
                    // need to know what type will be used
                    static::hydrateClonedInstance($clonedInstance, $key, $propertyType, $value, $property);
                }
            }
            $usedKeys[] = $property->getName();
        }
        // now dynamically added ones
        $extraProperties = array_diff(array_keys((array) $class), $usedKeys);
        foreach ($extraProperties as $extraProperty) {
            // cannot determine their metadata, so just copy them
            if (isset($data[$extraProperty])) {
                $clonedInstance->{$extraProperty} = $data[$extraProperty];
            }
        }
        return $clonedInstance;
    }

    /**
     * Check if this property shall be skipped
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected static function hasSkipAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\OnlyInternal::class));
    }

    /**
     * Check if the property is used as reference to somewhere
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected static function hasRefAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\RefElement::class));
    }

    /**
     * Check if the property is used only in direction for response
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected static function hasDirectionAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\ResponseDirection::class));
    }

    /**
     * Check if the property is used only as attribute
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected static function isJustAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\JustAttribute::class));
    }

    /**
     * Use different attribute as target instead of the one now processed
     *
     * @param ReflectionProperty $property
     *
     * @return string|null
     */
    protected static function getRepresentsAttribute(ReflectionProperty $property): ?string
    {
        $attrs = $property->getAttributes(Attributes\Represents::class);
        foreach ($attrs as $attr) {
            $arguments = $attr->getArguments();
            $argument = reset($arguments);
            return !empty($argument) ? strval($argument) : null;
        }
        return null;
    }

    /**
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @throws ReflectionException
     *
     * @return string|null
     */
    protected static function getPropertyType(ReflectionProperty $property, mixed $value): ?string
    {
        if (is_a($property->getType(), ReflectionUnionType::class)) {
            return static::getPropertyTypeFromUnion($property, $value);
        } else {
            return $property->getType()->getName();
        }
    }

    /**
     * @param ReflectionProperty $property
     * @param mixed $value
     *
     * @throws ReflectionException
     *
     * @return string|null
     */
    protected static function getPropertyTypeFromUnion(ReflectionProperty $property, mixed $value): ?string
    {
        // compare against different types - first one match, use it
        $variableType = gettype($value);
        $classType = is_object($value) ? get_class($value) : null;
        $parentInstances = $classType ? static::getPropertyParentInstances($classType) : [];
        foreach ($property->getType()->getTypes() as $reflectedType) {
            if (in_array($reflectedType->getName(), $parentInstances)) {
                // objects are special in match
                return 'object';
            }
            if ($reflectedType->getName() == $variableType) {
                return $reflectedType->getName();
            }
        }
        return null;
    }

    /**
     * @param class-string $name
     *
     * @throws ReflectionException
     *
     * @return class-string[]
     */
    protected static function getPropertyParentInstances(string $name): array
    {
        $reflectionClass = new ReflectionClass($name);
        $usedClasses = array_merge([$name], $reflectionClass->getInterfaceNames());
        while ($parentClass = $reflectionClass->getParentClass()) {
            $usedClasses[] = $parentClass->getName();
            $usedClasses = $usedClasses + $reflectionClass->getInterfaceNames();
            $reflectionClass = $parentClass;
        }
        return $usedClasses;
    }

    /**
     * Hydrate cloned instance with type control and conversion
     *
     * @param AbstractDto $clonedInstance
     * @param string $key
     * @param string $propertyType
     * @param mixed $value
     * @param ReflectionProperty $property
     *
     * @return void
     */
    protected static function hydrateClonedInstance(
        AbstractDto & $clonedInstance,
        string $key,
        string $propertyType,
        mixed $value,
        ReflectionProperty $property,
    ): void {
        $clonedInstance->{$key} = match ($propertyType) {
            'iterable', 'array' => (array) $value,
            'bool' => is_bool($value) ? $value : (is_string($value) ? ('true' == $value) : boolval(intval($value))),
            'float' => floatval($value),
            'int' => intval($value),
            'null' => null,
            'object', 'mixed' => $value,
            'string' => strval($value),
            'false' => false,
            'true' => true,
            default => $property->getDefaultValue(),
        };
    }
}
