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
use Riesenia\Pohoda\Common;

class EstablishmentType extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:establishment', '', $this->namespace('typ'));

        $this->addElements($xml, $this->getDataElements(), 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setNormalizer('company', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string255'));
        $resolver->setNormalizer('city', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string45'));
        $resolver->setNormalizer('street', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('zip', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string15'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\EstablishmentTypeDto();
    }
}
