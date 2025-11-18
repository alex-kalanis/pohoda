<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property Receipt\ReceiptDto $data
 */
class Receipt extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:prijemka';
    }

    protected function getDocumentNamespace(): string
    {
        return 'pri';
    }

    protected function getDocumentName(): string
    {
        return 'prijemka';
    }

    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Receipt\ReceiptDto();
    }
}
