<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Picture extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:picture', '', $this->namespace('stk'));
        $xml->addAttribute('default', strval($this->data['default']));

        $this->addElements($xml, ['filepath', 'description', 'order'], 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['filepath', 'description', 'order', 'default']);

        // validate / format options
        $resolver->setRequired('filepath');
        $resolver->setNormalizer('order', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setDefault('default', 'false');
        $resolver->setNormalizer('default', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }
}
