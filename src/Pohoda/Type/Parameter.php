<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Parameter extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:parameter', '', $this->namespace('typ'));

        $child = $this->data['name'] ?? null;
        $xml->addChild('typ:name', is_null($child) ? null : strval($child));

        if ('list' == $this->data['type']) {
            $this->addRefElement($xml, 'typ:listValueRef', $this->data['value']);

            if (isset($this->data['list'])) {
                $this->addRefElement($xml, 'typ:list', $this->data['list']);
            }

            return $xml;
        }

        $xml->addChild('typ:' . $this->data['type'] . 'Value', \htmlspecialchars(strval($this->data['value'])));

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['name', 'type', 'value', 'list']);

        // validate / format options
        $resolver->setRequired('name');
        $resolver->setNormalizer('name', function (OptionsResolver $options, mixed $value): string {
            $prefix = 'VPr';
            $value = \strval($value);

            if ('list' == $options['type']) {
                $prefix = 'RefVPr';
            }

            if (str_starts_with($value, $prefix)) {
                return $value;
            }

            return $prefix . $value;
        });
        $resolver->setRequired('type');
        $resolver->setAllowedValues('type', ['text', 'memo', 'currency', 'boolean', 'number', 'datetime', 'integer', 'list']);
        $resolver->setNormalizer('value', function ($options, $value) {
            $normalizer = $options['type'];

            // date for datetime
            if ('datetime' == $normalizer) {
                $normalizer = 'date';
            }

            try {
                return \call_user_func($this->normalizerFactory->getClosure($normalizer), [], $value);
            } catch (\Exception) {
                return \is_array($value) ? $value : \strval($value);
            }
        });
    }
}
