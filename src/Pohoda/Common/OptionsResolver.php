<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

use Closure;
use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class OptionsResolver extends SymfonyOptionsResolver
{
    /** @var array<string, Closure> */
    protected array $loadedNormalizers = [];

    /**
     * Get normalizer.
     *
     * @param string $type
     *
     * @return Closure
     *
     * Technically it's factory
     */
    public function getNormalizer(string $type): Closure
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

        $this->loadedNormalizers[$type] = $normalizer->normalize(...); // Closure::fromCallable([$normalizer, 'normalize'])
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
     * @return OptionResolver\AbstractNormalizer
     * @see vendor/symfony/options-resolver/OptionsResolver.php:1128
     */
    protected function createNormalizer(string $type, array $param = []): OptionResolver\AbstractNormalizer
    {
        return match ($type) {
            'str', 'string' => new OptionResolver\Strings($param),
            'float', 'number' => new OptionResolver\Numbers($param),
            'int', 'integer' => new OptionResolver\Integers($param),
            'bool', 'boolean' => new OptionResolver\Booleans($param),
            'date' => new OptionResolver\Dates($param),
            'datetime' => new OptionResolver\DateTimes($param),
            'time' => new OptionResolver\Times($param),
            default => throw new \DomainException('Not a valid normalizer type: ' . $type),
        };
    }
}
