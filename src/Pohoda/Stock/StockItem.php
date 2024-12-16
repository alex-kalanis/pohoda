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
use Riesenia\Pohoda\Common;

class StockItem extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['stockInfo', 'storage'];

    /** @var string[] */
    protected array $elements = ['id', 'stockInfo', 'storage', 'code', 'name', 'count', 'quantity', 'stockPriceItem'];

    /**
     * {@inheritdoc}
     */
    public function __construct(Common\NamespacesPaths $namespacesPaths, array $data, string $ico, bool $resolveOptions = true)
    {
        // process stockPriceItem
        if (isset($data['stockPriceItem']) && is_array($data['stockPriceItem'])) {
            $data['stockPriceItem'] = \array_map(function ($stockPriceItem) use ($namespacesPaths, $ico, $resolveOptions) {
                return new Price($namespacesPaths, $stockPriceItem['stockPrice'], $ico, $resolveOptions);
            }, $data['stockPriceItem']);
        }

        parent::__construct($namespacesPaths, $data, $ico, $resolveOptions);
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
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('id', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('count', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
    }
}
