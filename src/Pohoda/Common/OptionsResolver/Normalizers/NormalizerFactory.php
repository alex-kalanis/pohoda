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
            // strings can be nullable and have length
            $normalizer = $this->createNormalizer('string', \intval(\substr($type, 7)), true);
        } elseif (str_starts_with($type, '?str')) {
            // short strings can be nullable and have length
            $normalizer = $this->createNormalizer('string', \intval(\substr($type, 4)), true);
        } elseif (str_starts_with($type, 'string')) {
            // strings have length
            $normalizer = $this->createNormalizer('string', \intval(\substr($type, 6)));
        } elseif (str_starts_with($type, 'str')) {
            // short strings have length
            $normalizer = $this->createNormalizer('string', \intval(\substr($type, 3)));
        } elseif (str_starts_with($type, '?')) {
            // types can be nullable
            $normalizer = $this->createNormalizer(\substr($type, 1), null, true);
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
     * @param int|null $length
     * @param bool     $nullable
     * @throws DomainException
     * @return AbstractNormalizer
     * @see vendor/symfony/options-resolver/OptionsResolver.php:1128
     */
    protected function createNormalizer(string $type, ?int $length = null, bool $nullable = false): AbstractNormalizer
    {
        return match ($type) {
            'str', 'string' => new Strings($length, $nullable),
            'float', 'number' => new Numbers($length, $nullable),
            'int', 'integer' => new Integers($length, $nullable),
            'bool', 'boolean' => new Booleans($length, $nullable),
            'date' => new Dates($length, $nullable),
            'datetime' => new DateTimes($length, $nullable),
            'time' => new Times($length, $nullable),
            'list_request_type' => new ListRequestType($length, $nullable),
            default => throw new DomainException('Not a valid normalizer type: ' . $type),
        };
    }
}
