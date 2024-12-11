<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


/**
 * Abstract class for normalization of dates
 *
 * Just set the final format in abstract
 */
abstract class AbstractDates extends AbstractNormalizer
{
    /**
     * The final format
     *
     * @return string
     */
    abstract protected function getFormat(): string;

    public function normalize(mixed $options, mixed $value): string
    {
        // param is used for nullable
        if (!empty($this->config['nullable']) && empty($value)) {
            return '';
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format($this->getFormat());
        }

        $time = \strtotime(\strval($value));

        if (!$time) {
            throw new \DomainException('Not a valid date: ' . $value);
        }

        return \date($this->getFormat(), $time);
    }
}
