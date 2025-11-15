<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Contract;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type\Address;

class Desc extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // process partner identity
        if (isset($data->partnerIdentity)) {
            $partnerIdentity = new Address($this->dependenciesFactory);
            $partnerIdentity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->partnerIdentity);
            $data->partnerIdentity = $partnerIdentity;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contractDesc', '', $this->namespace('con'));

        $this->addElements($xml, $this->getDataElements(), 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        $resolver->setNormalizer('datePlanStart', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('datePlanDelivery', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateStart', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateWarranty', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setRequired('text');
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new DescDto();
    }
}
