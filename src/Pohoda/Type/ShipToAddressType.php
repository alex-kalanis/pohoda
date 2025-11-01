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

class ShipToAddressType extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'country',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:shipToAddress', '', $this->namespace('typ'));

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
        $resolver->setNormalizer('division', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('name', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('city', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string45'));
        $resolver->setNormalizer('street', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string45'));
        $resolver->setNormalizer('zip', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string15'));
        $resolver->setNormalizer('phone', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string40'));
        $resolver->setNormalizer('email', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string98'));
        $resolver->setNormalizer('defaultShipAddress', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\ShipToAddressDto();
    }
}
