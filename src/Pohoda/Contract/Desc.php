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

    /** @var string[] */
    protected array $refElements = ['number', 'responsiblePerson'];

    /** @var string[] */
    protected array $elements = ['number', 'datePlanStart', 'datePlanDelivery', 'dateStart', 'dateDelivery', 'dateWarranty', 'text', 'partnerIdentity', 'responsiblePerson', 'note'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process partner identity
        if (isset($data['partnerIdentity'])) {
            $partnerIdentity = new Address($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['partnerIdentity'] = $partnerIdentity->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['partnerIdentity']);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contractDesc', '', $this->namespace('con'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('datePlanStart', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('datePlanDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateStart', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateWarranty', $this->normalizerFactory->getClosure('date'));
        $resolver->setRequired('text');
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string90'));
    }
}
