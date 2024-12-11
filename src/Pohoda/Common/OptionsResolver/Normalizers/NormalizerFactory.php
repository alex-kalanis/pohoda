<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


use Closure;
use DomainException;


class NormalizerFactory
{
    /** @var array<string, AbstractNormalizer> */
    protected array $loadedNormalizers = [];

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
            // strings have length
            $normalizer = $this->createNormalizer('string', ['length' => \intval(\substr($type, 7)), 'nullable' => true]);
        } elseif (str_starts_with($type, '?str')) {
            // types can be nullable
            $normalizer = $this->createNormalizer('string', ['length' => \intval(\substr($type, 4)), 'nullable' => true]);
        } elseif (str_starts_with($type, 'string')) {
            // strings have length
            $normalizer = $this->createNormalizer('string', ['length' => \intval(\substr($type, 6))]);
        } elseif (str_starts_with($type, 'str')) {
            // strings have length
            $normalizer = $this->createNormalizer('string', ['length' => \intval(\substr($type, 3))]);
        } elseif (str_starts_with($type, '?')) {
            // types can be nullable
            $normalizer = $this->createNormalizer(\substr($type, 1), ['nullable' => true]);
        } else {
            $normalizer = $this->createNormalizer($type);
        }

        $this->loadedNormalizers[$type] = $normalizer;
        return $this->loadedNormalizers[$type];
    }

    /**
     * Create normalizer.
     *
     * @param string     $type
     * @param array{
     *     length?: int|null,
     *     nullable?: bool|null,
     * } $param
     *
     * @throws DomainException
     * @return AbstractNormalizer
     * @see vendor/symfony/options-resolver/OptionsResolver.php:1128
     */
    protected function createNormalizer(string $type, array $param = []): AbstractNormalizer
    {
        return match ($type) {
            'str', 'string' => new Strings($param),
            'float', 'number' => new Numbers($param),
            'int', 'integer' => new Integers($param),
            'bool', 'boolean' => new Booleans($param),
            'date' => new Dates($param),
            'datetime' => new DateTimes($param),
            'time' => new Times($param),
            'list_request_type' => new ListRequestType($param),
            'parameter_name' => new ParameterName($param),
            default => throw new DomainException('Not a valid normalizer type: ' . $type),
        };
    }
}
