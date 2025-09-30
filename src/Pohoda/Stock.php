<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Stock\Header;
use Riesenia\Pohoda\Stock\Price;
use Riesenia\Pohoda\Stock\StockItem;

class Stock extends AbstractAgenda
{
    use Common\AddActionTypeTrait;
    use Common\AddParameterToHeaderTrait;
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // pass to header
        if (!empty($data)) {
            $header = new Header($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data = ['header' => $header->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data)];
        }

        return parent::setData($data);
    }

    public function getImportRoot(): string
    {
        return 'lStk:stock';
    }

    /**
     * Add stock item.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addStockItem(array $data): self
    {
        if (!isset($this->data['stockDetail'])
            || !(
                is_array($this->data['stockDetail'])
                || (is_object($this->data['stockDetail']) && is_a($this->data['stockDetail'], \ArrayAccess::class))
            )
        ) {
            $this->data['stockDetail'] = [];
        }

        $stockDetail = new StockItem($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['stockDetail'][] = $stockDetail->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * Add price.
     *
     * @param string $code
     * @param float  $value
     * @param string $id
     *
     * @return $this
     */
    public function addPrice(string $code, float $value, string $id = ''): self
    {
        if (!isset($this->data['stockPriceItem'])
            || !(
                is_array($this->data['stockPriceItem'])
                || (is_object($this->data['stockPriceItem']) && is_a($this->data['stockPriceItem'], \ArrayAccess::class))
            )
        ) {
            $this->data['stockPriceItem'] = [];
        }

        $price = new Price($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $data = [];
        if (!empty($id)) {
            $data['id'] = $id;
        }
        $data['ids'] = $code;
        $data['price'] = $value;
        $this->data['stockPriceItem'][] = $price->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * Add image.
     *
     * @param string   $filepath
     * @param string   $description
     * @param int|null $order
     * @param bool     $default
     *
     * @return $this
     */
    public function addImage(string $filepath, string $description = '', int $order = null, bool $default = false): self
    {
        $object = $this->data['header'];
        /** @var Header $object */
        $object->addImage($filepath, $description, $order, $default);

        return $this;
    }

    /**
     * Add category.
     *
     * @param int $categoryId
     *
     * @return $this
     */
    public function addCategory(int $categoryId): self
    {
        $object = $this->data['header'];
        /** @var Header $object */
        $object->addCategory($categoryId);

        return $this;
    }

    /**
     * Add int parameter.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addIntParameter(array $data): self
    {
        $object = $this->data['header'];
        /** @var Header $object */
        $object->addIntParameter($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $namespace = empty($this->namespace) ? 'stk' : $this->namespace;
        $xml = $this->createXML()->addChild(
            ($this->useOneDirectionalVariables ? $namespace : 'stk'). ':stock',
            '',
            $this->namespace(($this->useOneDirectionalVariables ? $namespace : 'stk')),
        );
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['actionType', 'header', 'stockDetail', 'stockPriceItem'], 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }
}
