<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property Stock\StockDto $data
 */
class Stock extends AbstractAgenda
{
    use Common\AddActionTypeTrait;
    use Common\AddParameterToHeaderTrait;
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // pass to header
        if (!empty($data->header)) {
            $header = new Stock\Header($this->dependenciesFactory);
            $header
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->header);
            $data->header = $header;
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
     * @param Stock\StockItemDto $data
     *
     * @return $this
     */
    public function addStockItem(Stock\StockItemDto $data): self
    {
        $stockDetail = new Stock\StockItem($this->dependenciesFactory);
        $stockDetail
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->stockDetail[] = $stockDetail;

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
        $priceDto = new Stock\PriceDto();
        if (!empty($id)) {
            $priceDto->id = $id;
        }
        $priceDto->ids = $code;
        $priceDto->price = $value;
        $price = new Stock\Price($this->dependenciesFactory);
        $price
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($priceDto);
        $this->data->stockPriceItem[] = $price;

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
        $object = $this->data->header;
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
        $object = $this->data->header;
        $object->addCategory($categoryId);

        return $this;
    }

    /**
     * Add int parameter.
     *
     * @param Stock\IntParameterDto $data
     *
     * @return $this
     */
    public function addIntParameter(Stock\IntParameterDto $data): self
    {
        $object = $this->data->header;
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

        $this->addElements($xml, $this->getDataElements(), 'stk');

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

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Stock\StockDto();
    }
}
