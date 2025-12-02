<?php

namespace kalanis\Pohoda\Common\Dtos;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Enums;

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
            fn($in) => !(is_null($in) || (is_array($in) && empty($in))),
        );
    }

    /**
     * Remap enums to their values, do not pass them
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function remapEnumData(array $data): array
    {
        return array_map(
            fn($in) => is_object($in) && is_a($in, Enums\EnhancedEnumInterface::class) ? $in->currentValue() : $in,
            $data,
        );
    }

    /**
     * Get all options as set in classes set for available attributes
     *
     * @param AbstractDto $class
     * @param bool $responseDirection
     *
     * @return array<string, object[]>
     */
    public static function getOptions(AbstractDto $class, bool $responseDirection): array
    {
        $reflection = new ReflectionClass($class);
        $allProperties = $reflection->getProperties();
        $ref = [];
        foreach ($allProperties as $property) {
            if (static::hasInternalAttribute($property)) {
                continue;
            }
            if (static::hasDirectionAttribute($property) && !$responseDirection) {
                continue;
            }
            $options = static::getOptionAttributes($property);
            foreach ($options as $option) {
                $propName = $property->getName();
                if (!isset($ref[$propName])) {
                    $ref[$propName] = [];
                }
                $ref[$propName][] = $option->newInstance();
            }
        }
        return $ref;
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
            if (static::hasInternalAttribute($property)) {
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
     * Get all attributes from DTOs which are just attributes to different elements in target XML
     *
     * @param AbstractDto $class
     * @param bool $responseDirection
     *
     * @return array<string, Attributes\AttributeExtend>
     */
    public static function getAttributesExtendingElements(AbstractDto $class, bool $responseDirection): array
    {
        $reflection = new ReflectionClass($class);
        $allProperties = $reflection->getProperties();
        $ref = [];
        foreach ($allProperties as $property) {
            if (static::hasInternalAttribute($property)) {
                continue;
            }
            if (static::isJustAttribute($property)) {
                continue;
            }
            if (static::hasDirectionAttribute($property) && !$responseDirection) {
                continue;
            }
            if ($extend = static::getExtendingAttribute($property)) {
                $ref[$property->getName()] = $extend;
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
        $reflection = new ReflectionClass($class);
        $props = [];
        foreach ($reflection->getProperties() as $prop) {
            if (static::hasInternalAttribute($prop)) {
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
            $usedKeys[] = $property->getName();
            if (static::hasInternalAttribute($property)) {
                continue;
            }
            if (static::hasDirectionAttribute($property) && !$responseDirection) {
                continue;
            }

            if (isset($data[$property->getName()])) {
                $value = $data[$property->getName()];
                $propertyType = static::getPropertyType($property, $value);

                if (!empty($propertyType)) {
                    // need to know what type will be used; there can be multiple targets, so it need to behave correctly
                    foreach (static::getRepresentsAttributes($property) as $key) {
                        static::hydrateClonedInstance($clonedInstance, $key, $propertyType, $value, $property);
                    }
                }
            }
        }

        // now dynamically added ones
        static::hydrateDynamicallySetProperties($clonedInstance, $class, $usedKeys, $data);
        return $clonedInstance;
    }

    /**
     * Check if this property shall be skipped
     *
     * @param ReflectionProperty $property
     *
     * @return bool
     */
    protected static function hasInternalAttribute(ReflectionProperty $property): bool
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
     * @return iterable<string>
     */
    protected static function getRepresentsAttributes(ReflectionProperty $property): iterable
    {
        $attrs = $property->getAttributes(Attributes\Represents::class);
        $anyDefined = false;
        foreach ($attrs as $attr) {
            $instance = $attr->newInstance();
            if (\is_a($instance, Attributes\Represents::class)) {
                foreach ((array) $instance->differentVariable as $variable) {
                    $anyDefined = true;
                    yield $variable;
                }
            }
        }
        if (!$anyDefined) {
            yield $property->getName();
        }
    }

    /**
     * Use different attribute as target in XML instead that one used
     *
     * @param ReflectionProperty $property
     *
     * @return null|Attributes\AttributeExtend
     */
    protected static function getExtendingAttribute(ReflectionProperty $property): ?Attributes\AttributeExtend
    {
        $attrs = $property->getAttributes(Attributes\AttributeExtend::class);
        foreach ($attrs as $attr) {
            $instance = $attr->newInstance();
            if (\is_a($instance, Attributes\AttributeExtend::class)) {
                return $instance;
            }
        }
        return null;
    }

    /**
     * Use different attribute as target instead of the one now processed
     *
     * @param ReflectionProperty $property
     *
     * @return ReflectionAttribute<object>[]
     */
    protected static function getOptionAttributes(ReflectionProperty $property): array
    {
        return $property->getAttributes(Attributes\Options\AbstractOption::class, ReflectionAttribute::IS_INSTANCEOF);
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
        $type = $property->getType();
        if (empty($type)) {
            // @codeCoverageIgnoreStart
            // cannot find the case, but the definition says there is at least one
            return null;
        }
        // @codeCoverageIgnoreEnd
        if (\is_a($type, ReflectionUnionType::class)) {
            return static::getPropertyTypeFromUnion($type, $value);
        }
        if (\method_exists($type, 'getName')) {
            return $type->getName();
        }
        // @codeCoverageIgnoreStart
        // last fallback when everything else fails
        return \get_class($type);
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param ReflectionUnionType $unionType
     * @param mixed $value
     *
     * @throws ReflectionException
     *
     * @return string|null
     */
    protected static function getPropertyTypeFromUnion(ReflectionUnionType $unionType, mixed $value): ?string
    {
        $mapTypes = [
            'str' => 'string',
            'string' => 'string',
            'bool' => 'boolean',
            'boolean' => 'boolean',
            'int' => 'integer',
            'integer' => 'integer',
            'float' => 'float',
            'double' => 'float',
        ];

        // compare against different types - first one match, use it
        $variableType = \gettype($value);
        $classType = \is_object($value) ? \get_class($value) : null;
        $parentInstances = $classType ? static::getPropertyParentInstances($classType) : [];
        foreach ($unionType->getTypes() as $reflectedType) {
            if (is_a($reflectedType, ReflectionNamedType::class)) {
                if (in_array($reflectedType->getName(), $parentInstances)) {
                    // objects are special in match
                    return 'object';
                }
                // in map
                if (isset($mapTypes[$reflectedType->getName()])) {
                    return $mapTypes[$reflectedType->getName()];
                }
                // direct
                if ($reflectedType->getName() == $variableType) {
                    return $reflectedType->getName();
                }
            }
        }
        // @codeCoverageIgnoreStart
        // last fallback when \ReflectionUnionType pass some unrecognizable shit
        return null;
        // @codeCoverageIgnoreEnd
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
            'bool' => \is_bool($value) ? $value : (\is_string($value) ? ('true' == $value) : \boolval(\intval($value))),
            'float', 'double' => \floatval($value),
            'int' => \intval($value),
            'null' => null,
            'object', 'mixed' => $value,
            'string' => \strval($value),
            'false' => false,
            'true' => true,
            default => $property->getDefaultValue(),
        };
    }

    /**
     * Hydrate properties which has been set dynamically
     *
     * @param AbstractDto $clonedInstance
     * @param AbstractDto $sourceClass
     * @param string[] $usedKeys
     * @param array<string, mixed> $data
     *
     * @return void
     */
    protected static function hydrateDynamicallySetProperties(
        AbstractDto & $clonedInstance,
        AbstractDto $sourceClass,
        array       $usedKeys,
        array       $data,
    ): void {
        $properties = \array_diff(\array_keys((array) $sourceClass), $usedKeys);
        $filledProperties = [];
        foreach ($properties as $property) {
            // cannot determine their metadata, so just copy them
            if (isset($data[$property])) {
                $filledProperties[] = $property;
                $clonedInstance->{$property} = $data[$property];
            }
        }
        // the rest which has not been affected - copy values from the source
        $unaffectedPropertyKeys = \array_diff($properties, $filledProperties);
        foreach ($unaffectedPropertyKeys as $unaffectedPropertyKey) {
            $clonedInstance->{$unaffectedPropertyKey} = $sourceClass->{$unaffectedPropertyKey};
        }
    }
}
