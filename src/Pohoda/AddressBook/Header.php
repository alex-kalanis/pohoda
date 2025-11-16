<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\AddressBook;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type\Address;

/**
 * @property HeaderDto $data
 */
class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process identity
        if (isset($data->identity)) {
            $identity = new Address($this->dependenciesFactory);
            $identity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->identity);
            $data->identity = $identity;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('adb:addressbookHeader', '', $this->namespace('adb'));

        $this->addElements($xml, $this->getDataElements(), 'adb');

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
        $resolver->setNormalizer('region', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('phone', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string40'));
        $resolver->setNormalizer('mobil', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string24'));
        $resolver->setNormalizer('fax', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string24'));
        $resolver->setNormalizer('email', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string98'));
        $resolver->setNormalizer('web', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('ICQ', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string12'));
        $resolver->setNormalizer('Skype', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('GPS', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string38'));
        $resolver->setNormalizer('credit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceIDS', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('maturity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('agreement', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string12'));
        $resolver->setNormalizer('ost1', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string8'));
        $resolver->setNormalizer('ost2', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string8'));
        $resolver->setNormalizer('p1', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('p2', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('p3', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('p4', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('p5', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('p6', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('message', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
