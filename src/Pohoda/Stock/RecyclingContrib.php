<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class RecyclingContrib extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['recyclingContribType'];

    /** @var string[] */
    protected array $elements = ['recyclingContribType', 'coefficientOfRecyclingContrib'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:recyclingContrib', '', $this->namespace('stk'));

        $this->addElements($xml, $this->elements, 'stk');

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
        $resolver->setNormalizer('coefficientOfRecyclingContrib', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
    }
}
