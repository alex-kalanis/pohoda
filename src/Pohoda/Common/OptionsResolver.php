<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

use Symfony\Component\OptionsResolver\OptionsResolver as SymfonyOptionsResolver;

class OptionsResolver extends SymfonyOptionsResolver
{
    /**
     * Date formats.
     */
    const DATE_FORMATS = [
        'date' => 'Y-m-d',
        'datetime' => 'Y-m-d\TH:i:s',
        'time' => 'H:i:s'
    ];

    /** @var array<string,\Closure> */
    protected array $loadedNormalizers = [];

    /**
     * Get normalizer.
     *
     * @param string $type
     *
     * @return \Closure
     */
    public function getNormalizer(string $type): \Closure
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

        return $normalizer;
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
     * @return \Closure
     */
    protected function createNormalizer(string $type, array $param = []): \Closure
    {
        switch ($type) {
            case 'str':
            case 'string':
                return function ($options, $value) use ($param): string {
                    // remove new lines
                    $value = \str_replace(["\r\n", "\r", "\n"], ' ', \strval($value));

                    // param is used for string length
                    $length = empty($param['length']) ? null : \intval($param['length']);
                    return \mb_substr(\strval($value), 0, $length, 'utf-8');
                };

            case 'date':
            case 'datetime':
            case 'time':
                $format = static::DATE_FORMATS[$type];

                return function ($options, $value) use ($param, $format): string {
                    // param is used for nullable
                    if (!empty($param['nullable']) && empty($value)) {
                        return '';
                    }

                    if ($value instanceof \DateTimeInterface) {
                        return $value->format($format);
                    }

                    $time = \strtotime($value);

                    if (!$time) {
                        throw new \DomainException('Not a valid date: ' . $value);
                    }

                    return \date($format, $time);
                };

            case 'float':
            case 'number':
                return function ($options, $value) use ($param): string {
                    $preform = \strval(
                        \preg_replace(
                            '/[^0-9,.-]/',
                            '',
                            \strval($value)
                        )
                    );
                    if (!empty($param['nullable']) && empty(\strlen($preform))) {
                        return '';
                    }
                    return \str_replace(
                        ',',
                        '.',
                        \strval(
                            \floatval(
                                \str_replace(
                                    ',',
                                    '.',
                                    $preform
                                )
                            )
                        )
                    );
                };

            case 'int':
            case 'integer':
                return function ($options, $value) use ($param): string {
                    $preform = \strval(
                        \preg_replace(
                            '/[^0-9,.-]/',
                            '',
                            \strval($value)
                        )
                    );
                    if (!empty($param['nullable']) && empty(\strlen($preform))) {
                        return '';
                    }
                    return \strval(
                        \intval(
                            \str_replace(
                                ',',
                                '.',
                                $preform
                            )
                        )
                    );
                };

            case 'bool':
            case 'boolean':
                return function ($options, $value) use ($param): string {
                    if (!empty($param['nullable']) && empty($value) && !\is_bool($value)) {
                        return '';
                    }
                    return !$value || \is_string($value) && 'false' === \strtolower($value) ? 'false' : 'true';
                };

            default:
                throw new \DomainException('Not a valid normalizer type: ' . $type);
        }
    }
}
