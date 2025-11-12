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
use Riesenia\Pohoda\Common;

class Filter extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'extId',
        'storage',
        'store',
        'selectedNumbers',
        'selectedCompanys',
        'selectedIco',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ftr:filter', '', $this->namespace('ftr'));

        $this->addElements($xml, $this->getDataElements(), 'ftr');

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
        $resolver->setNormalizer('id', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('internet', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('lastChanges', $this->dependenciesFactory->getNormalizerFactory()->getClosure('datetime'));
        $resolver->setNormalizer('dateFrom', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateTill', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new FilterDto();
    }
}
