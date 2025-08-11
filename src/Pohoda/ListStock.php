<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class ListStock extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild($this->data['namespace'] . ':list' . $this->data['type'], '', $this->namespace(strval($this->data['namespace'])));
        $xml->addAttribute('version', '2.0');

        if ($this->data['timestamp']) {
            $date = $this->data['timestamp'];
            if (is_object($date) && is_a($date, \DateTimeInterface::class)) {
                $date = $date->format('Y-m-d\TH:i:s');
            }
            $xml->addAttribute('dateTimeStamp', strval($date));
        }

        if ($this->data['validFrom']) {
            $dateFrom = $this->data['validFrom'];
            if (is_object($date) && is_a($dateFrom, \DateTimeInterface::class)) {
                $dateFrom = $dateFrom->format('Y-m-d');
            }
            $xml->addAttribute('dateValidFrom', strval($dateFrom));
        }

        if ($this->data['state']) {
            $xml->addAttribute('state', strval($this->data['state']));
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['type', 'namespace', 'timestamp', 'validFrom', 'state']);

        // validate / format options
        $resolver->setRequired('type');
        $resolver->setNormalizer('type', $this->normalizerFactory->getClosure('list_request_type'));
        $resolver->setDefault('namespace', function (Options $options) {
            return 'lst';
        });
    }
}
