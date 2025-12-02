<?php

namespace kalanis\Pohoda\Common\OptionsResolver\Normalizers;

use Closure;
use kalanis\Pohoda\Common;
use kalanis\PohodaException;

class NormalizerFactory
{
    public static function loadNormalizersFromDto(
        Common\OptionsResolver $resolver,
        Common\Dtos\AbstractDto $dto,
        bool $useOneDirectionalVariables,
    ): void {
        $propertyOptions = Common\Dtos\Processing::getOptions($dto, $useOneDirectionalVariables);
        foreach ($propertyOptions as $propertyName => $allOptions) {
            foreach ($allOptions as $option) {
                if (is_a($option, Common\Attributes\Options\AbstractOption::class)) {
                    switch ($option->getAction()) {
                        case Common\OptionsResolver\ActionsEnum::DEFAULT_VALUES:
                            static::fillDefaultValues($resolver, $option, $propertyName);
                            break;
                        case Common\OptionsResolver\ActionsEnum::IS_REQUIRED:
                            static::fillAsRequired($resolver, $propertyName);
                            break;
                        case Common\OptionsResolver\ActionsEnum::NORMALIZER:
                            static::fillNormalizers($resolver, $option, $propertyName, $dto);
                            break;
                        case Common\OptionsResolver\ActionsEnum::ALLOWED_VALUES:
                            static::fillAllowedValues($resolver, $option, $propertyName);
                            break;
                            // @codeCoverageIgnoreStart
                            // okay, I do not know what might happen when I will want to use check by types
                        case Common\OptionsResolver\ActionsEnum::ALLOWED_TYPES:
                            static::fillAllowedTypes($resolver, $option, $propertyName);
                            break;
                            // @codeCoverageIgnoreEnd
                    };
                }
            }
        }
    }

    protected static function fillDefaultValues(
        Common\OptionsResolver $resolver,
        Common\Attributes\Options\AbstractOption $option,
        string $propertyName,
    ): void {
        if (\is_callable($option->value)) {
            $resolver->setDefault($propertyName, Closure::fromCallable($option->value));
        } else {
            $resolver->setDefault($propertyName, $option->value);
        }
    }

    protected static function fillAsRequired(
        Common\OptionsResolver $resolver,
        string $propertyName,
    ): void {
        $resolver->setRequired($propertyName);
    }

    protected static function fillNormalizers(
        Common\OptionsResolver $resolver,
        Common\Attributes\Options\AbstractOption $option,
        string $propertyName,
        Common\Dtos\AbstractDto $dto,
    ): void {
        $reflect = new \ReflectionClass($option->getNormalizer());
        $instance = $reflect->newInstance();
        if (is_a($instance, AbstractNormalizer::class)) {
            $instance->setParams(
                \is_null($option->value) ? null : (\is_numeric($option->value) || \is_string($option->value) ? \intval($option->value) : null),
                $option->isNullable,
                $option->value,
                $dto,
            );
            $resolver->setNormalizer($propertyName, $instance->normalize(...));
        }
    }

    protected static function fillAllowedValues(
        Common\OptionsResolver $resolver,
        Common\Attributes\Options\AbstractOption $option,
        string $propertyName,
    ): void {
        $resolver->setAllowedValues($propertyName, $option->value);
    }

    // @codeCoverageIgnoreStart
    // okay, I do not know what might happen when I will want to use check by types
    protected static function fillAllowedTypes(
        Common\OptionsResolver $resolver,
        Common\Attributes\Options\AbstractOption $option,
        string $propertyName,
    ): void {
        $values = array_map(fn($v) => \strval($v), (array) $option->value);
        $resolver->setAllowedTypes($propertyName, $values);
    }
    // @codeCoverageIgnoreEnd

    /**
     * Create normalizer.
     *
     * @param string   $type
     * @throws PohodaException
     * @return AbstractNormalizer
     * @see vendor/symfony/options-resolver/OptionsResolver.php:1128
     */
    public static function createNormalizer(string $type): AbstractNormalizer
    {
        return match ($type) {
            'str', 'string' => new Strings(),
            'float', 'number' => new Numbers(),
            'int', 'integer' => new Integers(),
            'bool', 'boolean' => new Booleans(),
            'date' => new Dates(),
            'datetime' => new DateTimes(),
            'time' => new Times(),
            'list_request_type' => new ListRequestType(),
            default => throw new PohodaException('Not a valid normalizer type: ' . $type),
        };
    }
}
