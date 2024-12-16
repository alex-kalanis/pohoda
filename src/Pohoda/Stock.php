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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Stock extends AbstractAgenda
{
    use Common\AddActionTypeTrait;
    use Common\AddParameterToHeaderTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $ico,
        bool $resolveOptions = true,
    )
    {
        // pass to header
        if ($data) {
            $data = ['header' => new Header($namespacesPaths, $sanitizeEncoding, $data, $ico, $resolveOptions)];
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $ico, $resolveOptions);
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

        $this->data['stockDetail'][] = new StockItem($this->namespacesPaths, $this->sanitizeEncoding, $data, $this->ico);

        return $this;
    }

    /**
     * Add price.
     *
     * @param string $code
     * @param float  $value
     *
     * @return $this
     */
    public function addPrice(string $code, float $value): self
    {
        if (!isset($this->data['stockPriceItem'])
            || !(
                is_array($this->data['stockPriceItem'])
                || (is_object($this->data['stockPriceItem']) && is_a($this->data['stockPriceItem'], \ArrayAccess::class))
            )
        ) {
            $this->data['stockPriceItem'] = [];
        }

        $this->data['stockPriceItem'][] = new Price($this->namespacesPaths, $this->sanitizeEncoding, [
            'ids' => $code,
            'price' => $value
        ], $this->ico);

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
        $xml = $this->createXML()->addChild('stk:stock', '', $this->namespace('stk'));
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
