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
 * @property Dtos\TaxDocumentDto $data
 */
class TaxDocument extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process source liquidation
        if (isset($data->sourceLiquidation)) {
            $sourceLiquidation = new SourceLiquidation($this->dependenciesFactory);
            $sourceLiquidation
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->sourceLiquidation);
            $data->sourceLiquidation = $sourceLiquidation;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('int:taxDocument', '', $this->namespace('int'));

        $this->addElements($xml, $this->getDataElements(), 'int');

        return $xml;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\TaxDocumentDto();
    }
}
