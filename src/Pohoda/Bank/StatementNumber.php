<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class StatementNumber extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = [
        'statementNumber',
        'numberMovement',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('bnk:statementNumber', '', $this->namespace('bnk'));

        $this->addElements($xml, $this->elements, 'bnk');

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
        $resolver->setNormalizer('statementNumber', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('numberMovement', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string6'));
    }
}
