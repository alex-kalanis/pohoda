<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Invoice\AdvancePaymentItem;
use Riesenia\Pohoda\Type\Link;

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
                || (is_object($this->data['links']) && is_a($this->data['links'], \ArrayAccess::class))
            )
        ) {
            $this->data['links'] = [];
        }

        $link = new Link($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['links'][] = $link->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

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
                || (is_object($this->data['invoiceDetail']) && is_a($this->data['invoiceDetail'], \ArrayAccess::class))
            )
        ) {
            $this->data['invoiceDetail'] = [];
        }

        $invoiceDetail = new AdvancePaymentItem($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['invoiceDetail'][] = $invoiceDetail->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

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
