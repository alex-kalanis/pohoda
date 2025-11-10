<?php

namespace Riesenia\Pohoda\Common\Dtos;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use ReflectionUnionType;
use Riesenia\Pohoda\Common\Attributes;

class Hydrate
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
     * Fill DTO with data, change types when necessary
     *
     * @param AbstractDto $class
     * @param array<string, mixed> $data
     * @param bool $responseDirection
     * @throws ReflectionException
     * @return AbstractDto
     *
     * I do not want to look at this more than I need
     * todo: 8.1 - detekce podle extra atributu, ne podle polozek poli
     */
    public static function fill(AbstractDto $class, array $data, bool $responseDirection): AbstractDto
    {
        $reflection = new ReflectionClass($class);
        $clonedInstance = $reflection->newInstance();
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
        }
        return $clonedInstance;
    }

    protected static function hasSkipAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\OnlyInternal::class));
    }

    protected static function hasRefAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\RefElement::class));
    }

    protected static function hasDirectionAttribute(ReflectionProperty $property): bool
    {
        return !empty($property->getAttributes(Attributes\ResponseDirection::class));
    }

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

    protected static function getPropertyType(ReflectionProperty $property, mixed $value): ?string
    {
        if (is_a($property->getType(), ReflectionUnionType::class)) {
            // compare against different types - first one match, use it
            return static::getPropertyTypeFromUnion($property, $value);
        } else {
            return $property->getType()->getName();
        }
    }

    protected static function getPropertyTypeFromUnion(ReflectionProperty $property, mixed $value): ?string
    {
        // compare against different types - first one match, use it
        $propertyType = null;
        $variableType = gettype($value);
        $classType = is_object($value) ? get_class($value) : null;
        foreach ($property->getType()->getTypes() as $reflectedType) {
            if ($classType && ($reflectedType->getName() == $classType)) {
                // objects are special in match
                $propertyType = 'object';
                break;
            }
            if ($reflectedType->getName() == $variableType) {
                $propertyType = $reflectedType->getName();
                break;
            }
        }
        return $propertyType;
    }

    protected static function hydrateClonedInstance(
        AbstractDto & $clonedInstance,
        string $key,
        string $propertyType,
        mixed $value,
        ReflectionProperty $property,
    ): void {
        $clonedInstance->{$key} = match ($propertyType) {
            'iterable', 'array' => (array) $value,
            'bool' => is_string($value) ? 'true' == $value : boolval(intval($value)),
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
