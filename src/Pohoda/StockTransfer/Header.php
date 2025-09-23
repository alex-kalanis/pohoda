<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['number', 'store', 'centreSource', 'centreDestination', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['number', 'date', 'time', 'dateOfReceipt', 'timeOfReceipt', 'symPar', 'store', 'text', 'partnerIdentity', 'centreSource', 'centreDestination', 'activity', 'contract', 'note', 'intNote'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process partner identity
        if (isset($data['partnerIdentity'])) {
            $partnerIdentity = new Type\Address($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data['partnerIdentity'] = $partnerIdentity->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['partnerIdentity']);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('pre:prevodkaHeader', '', $this->namespace('pre'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'pre');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('time', $this->normalizerFactory->getClosure('time'));
        $resolver->setNormalizer('dateOfReceipt', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('timeOfReceipt', $this->normalizerFactory->getClosure('time'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string48'));
    }
}
