<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Filter extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['extId', 'storage', 'store', 'selectedNumbers', 'selectedCompanys', 'selectedIco'];

    /** @var string[] */
    protected array $elements = ['id', 'extId', 'code', 'EAN', 'name', 'storage', 'store', 'internet', 'company', 'ico', 'dic', 'lastChanges', 'dateFrom', 'dateTill', 'selectedNumbers', 'selectedCompanys', 'selectedIco'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ftr:filter', '', $this->namespace('ftr'));

        $this->addElements($xml, $this->elements, 'ftr');

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
        $resolver->setNormalizer('id', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('internet', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('lastChanges', $this->dependenciesFactory->getNormalizerFactory()->getClosure('datetime'));
        $resolver->setNormalizer('dateFrom', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateTill', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
    }
}
