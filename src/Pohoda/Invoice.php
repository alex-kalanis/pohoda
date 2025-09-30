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
 * @property array{
 *     links?: iterable<Type\Link>,
 *     invoiceDetail?: iterable<Invoice\AdvancePaymentItem>,
 * } $data
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
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addLink(array $data): self
    {
        if (!isset($this->data['links'])
            || !(
                is_array($this->data['links'])
                || (is_a($this->data['links'], \ArrayAccess::class))
            )
        ) {
            $this->data['links'] = [];
        }

        $link = new Type\Link($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $link->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['links'][] = $link;

        return $this;
    }

    /**
     * Add advance payment item.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addAdvancePaymentItem(array $data): self
    {
        if (!isset($this->data['invoiceDetail'])
            || !(
                is_array($this->data['invoiceDetail'])
                || (is_a($this->data['invoiceDetail'], \ArrayAccess::class))
            )
        ) {
            $this->data['invoiceDetail'] = [];
        }

        $invoiceDetail = new Invoice\AdvancePaymentItem($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $invoiceDetail->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['invoiceDetail'][] = $invoiceDetail;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentElements(): array
    {
        return \array_merge(parent::getDocumentElements(), ['links']);
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
}
