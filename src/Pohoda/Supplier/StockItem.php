<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

class StockItem extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'stockItem',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:stockItem', '', $this->namespace('sup'));

        $this->addElements($xml, $this->getDataElements(), 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new StockItemDto();
    }
}
