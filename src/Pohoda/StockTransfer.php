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
 * @property StockTransfer\StockTransferDto $data
 */
class StockTransfer extends AbstractAgenda
{
    use Common\AddParameterToHeaderTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // pass to header
        $header = new StockTransfer\Header($this->dependenciesFactory);
        $header
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $data = new StockTransfer\StockTransferDto();
        $data->header = $header;

        return parent::setData($data);
    }

    public function getImportRoot(): string
    {
        return 'lst:prevodka';
    }

    /**
     * Add item.
     *
     * @param StockTransfer\ItemDto $data
     *
     * @return $this
     */
    public function addItem(StockTransfer\ItemDto $data): self
    {
        $prevodkaDetail = new StockTransfer\Item($this->dependenciesFactory);
        $prevodkaDetail
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->prevodkaDetail[] = $prevodkaDetail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('pre:prevodka', '', $this->namespace('pre'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, $this->getDataElements(), 'pre');

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
        return new StockTransfer\StockTransferDto();
    }
}
