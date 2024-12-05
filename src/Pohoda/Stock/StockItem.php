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

class StockItem extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['stockInfo', 'storage'];

    /** @var string[] */
    protected array $elements = ['id', 'stockInfo', 'storage', 'code', 'name', 'count', 'quantity', 'stockPriceItem'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process stockPriceItem
        if (isset($data['stockPriceItem']) && is_array($data['stockPriceItem'])) {
            $data['stockPriceItem'] = \array_map(function ($stockPriceItem) use ($ico, $resolveOptions) {
                return new Price($stockPriceItem['stockPrice'], $ico, $resolveOptions);
            }, $data['stockPriceItem']);
        }

        parent::__construct($data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockItem', '', $this->namespace('stk'));

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

        $resolver->setNormalizer('id', $resolver->getNormalizer('int'));
        $resolver->setNormalizer('count', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('quantity', $resolver->getNormalizer('float'));
    }
}
