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
 * @property Invoice\InvoiceDto $data
 */
class Invoice extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:invoice';
    }

    /**
     * Add link.
     *
     * @param Type\Dtos\LinkDto $data
     *
     * @return $this
     */
    public function addLink(Type\Dtos\LinkDto $data): self
    {
        $link = new Type\Link($this->dependenciesFactory);
        $link
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->links[] = $link;

        return $this;
    }

    /**
     * Add advance payment item.
     *
     * @param Invoice\AdvancePaymentItemDto $data
     *
     * @return $this
     */
    public function addAdvancePaymentItem(Invoice\AdvancePaymentItemDto $data): self
    {
        $invoiceDetail = new Invoice\AdvancePaymentItem($this->dependenciesFactory);
        $invoiceDetail
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->invoiceDetail[] = $invoiceDetail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'inv';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Invoice\InvoiceDto();
    }
}
