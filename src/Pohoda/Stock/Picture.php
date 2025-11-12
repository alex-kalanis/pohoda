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
use Riesenia\Pohoda\Common;

/**
 * @property PictureDto $data
 */
class Picture extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:picture', '', $this->namespace('stk'));
        $xml->addAttribute('default', $this->data->default);

        $this->addElements($xml, $this->getDataElements(), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements(true));

        // validate / format options
        $resolver->setRequired('filepath');
        $resolver->setNormalizer('order', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setDefault('default', 'false');
        $resolver->setNormalizer('default', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new PictureDto();
    }
}
