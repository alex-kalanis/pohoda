<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

class CashSlip extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:prodejka';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'pro';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'prodejka';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new CashSlip\CashSlipDto();
    }
}
