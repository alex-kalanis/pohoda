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

class QueryFilter extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['filter', 'textName'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ftr:queryFilter', '', $this->namespace('ftr'));

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
        $resolver->setNormalizer('filter', $this->normalizerFactory->getClosure('string'));
        $resolver->setNormalizer('textName', $this->normalizerFactory->getClosure('string200'));
    }
}
