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
use Riesenia\Pohoda\Common;

/**
 * @property array{
 *     sourceLiquidation?: SourceLiquidation,
 * } $data
 */
class TaxDocument extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = [
        'sourceLiquidation',
    ];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process source liquidation
        if (isset($data['sourceLiquidation'])) {
            $sourceLiquidation = new SourceLiquidation($this->dependenciesFactory);
            $sourceLiquidation
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data['sourceLiquidation']);
            $data['sourceLiquidation'] = $sourceLiquidation;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('int:taxDocument', '', $this->namespace('int'));

        $this->addElements($xml, $this->elements, 'int');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
