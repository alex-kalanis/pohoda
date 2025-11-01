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

class AddressType extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'country',
    ];

    /** @var string[] */
    protected array $elements = [
        'company',
        'division',
        'name',
        'city',
        'street',
        'zip',
        'ico',
        'dic',
        'VATPayerType',
        'icDph',
        'country',
        'phone',
        'mobilPhone',
        'fax',
        'email',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:address', '', $this->namespace('typ'));

        $this->addElements($xml, $this->elements, 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('company', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string255'));
        $resolver->setNormalizer('division', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('name', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('city', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string45'));
        $resolver->setNormalizer('street', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string45'));
        $resolver->setNormalizer('zip', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string15'));
        $resolver->setNormalizer('ico', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string15'));
        $resolver->setNormalizer('dic', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string18'));
        $resolver->setAllowedValues('VATPayerType', ['payer', 'non-payer', '']);
        $resolver->setNormalizer('icDph', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string18'));
        $resolver->setNormalizer('phone', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string40'));
        $resolver->setNormalizer('mobilPhone', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string24'));
        $resolver->setNormalizer('fax', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string24'));
        $resolver->setNormalizer('email', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string98'));
    }
}
