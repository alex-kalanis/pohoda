<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

use Closure;
use DomainException;
use Riesenia\Pohoda\Common;

class NormalizerFactory
{
    /** @var array<string, AbstractNormalizer> */
    protected array $loadedNormalizers = [];

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
                            static::fillNormalizers($resolver, $option, $propertyName);
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
        $resolver->setDefault($propertyName, $option->value);
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
    ): void {
        $reflect = new \ReflectionClass($option->getNormalizer());
        $instance = $reflect->newInstance();
        if (is_a($instance, AbstractNormalizer::class)) {
            $instance->setParams(
                \is_null($option->value) ? null : \intval($option->value),
                $option->isNullable,
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
     * @deprecated since 2025-11-17 v6.0.0
     * @use Common\Attributes\Options\AbstractOption attributes instead
     */
    public function getClosure(string $name): Closure
    {
        return $this->getNormalizer($name)->normalize(...);
    }

    /**
     * Get normalizer.
     *
     * @param string $type
     *
     * @throws DomainException
     * @return AbstractNormalizer
     */
    public function getNormalizer(string $type): AbstractNormalizer
    {
        if (isset($this->loadedNormalizers[$type])) {
            return $this->loadedNormalizers[$type];
        }

        if (str_starts_with($type, '?string')) {
            // strings can be nullable and have length
            $normalizer = $this->createNormalizer('string')->setParams(\intval(\substr($type, 7)), true);
        } elseif (str_starts_with($type, '?str')) {
            // short strings can be nullable and have length
            $normalizer = $this->createNormalizer('string')->setParams(\intval(\substr($type, 4)), true);
        } elseif (str_starts_with($type, 'string')) {
            // strings have length
            $normalizer = $this->createNormalizer('string')->setParams(\intval(\substr($type, 6)));
        } elseif (str_starts_with($type, 'str')) {
            // short strings have length
            $normalizer = $this->createNormalizer('string')->setParams(\intval(\substr($type, 3)));
        } elseif (str_starts_with($type, '?')) {
            // types can be nullable
            $normalizer = $this->createNormalizer(\substr($type, 1))->setParams(null, true);
        } else {
            $normalizer = $this->createNormalizer($type);
        }

        $this->loadedNormalizers[$type] = $normalizer;
        return $this->loadedNormalizers[$type];
    }

    /**
     * Create normalizer.
     *
     * @param string   $type
     * @throws DomainException
     * @return AbstractNormalizer
     * @see vendor/symfony/options-resolver/OptionsResolver.php:1128
     */
    protected function createNormalizer(string $type): AbstractNormalizer
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
            default => throw new DomainException('Not a valid normalizer type: ' . $type),
        };
    }
}
