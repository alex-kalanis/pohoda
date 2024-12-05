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

        if (str_starts_with($type, 'string')) {
            // strings have length
            $normalizer = $this->_createNormalizer('string', (int) \substr($type, 6));
        } elseif (str_starts_with($type, '?')) {
            // types can be nullable
            $normalizer = $this->_createNormalizer(\substr($type, 1), true);
        } else {
            $normalizer = $this->_createNormalizer($type);
        }

        $this->loadedNormalizers[$type] = $normalizer;

        return $normalizer;
    }

    /**
     * Create normalizer.
     *
     * @param string     $type
     * @param mixed|null $param
     *
     * @return \Closure
     */
    protected function _createNormalizer(string $type, mixed $param = null): \Closure
    {
        switch ($type) {
            case 'string':
                return function ($options, $value) use ($param) {
                    // remove new lines
                    $value = \str_replace(["\r\n", "\r", "\n"], ' ', $value);

                    // param is used for string length
                    return \mb_substr($value, 0, is_null($param) ? null : intval($param), 'utf-8');
                };

            case 'date':
            case 'datetime':
            case 'time':
                $format = static::DATE_FORMATS[$type];

                return function ($options, $value) use ($param, $format) {
                    // param is used for nullable
                    if ($param && !$value) {
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
                return function ($options, $value) {
                    return \str_replace(',', '.', (string) \floatval(\str_replace(',', '.', \strval(\preg_replace('/[^0-9,.-]/', '', (string) $value)))));
                };

            case 'int':
            case 'integer':
                return function ($options, $value) {
                    return (string) \intval($value);
                };

            case 'bool':
            case 'boolean':
                return function ($options, $value) {
                    return !$value || \is_string($value) && 'false' === \strtolower($value) ? 'false' : 'true';
                };

            default:
                throw new \DomainException('Not a valid normalizer type: ' . $type);
        }
    }
}
