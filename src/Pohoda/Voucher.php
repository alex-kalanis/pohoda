<?php

namespace kalanis\Pohoda;

/**
 * @property Voucher\VoucherDto $data
 */
class Voucher extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'vch:voucher';
    }

    protected function getDocumentNamespace(): string
    {
        return 'vch';
    }

    protected function getDocumentName(): string
    {
        return 'voucher';
    }

    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Voucher\VoucherDto();
    }
}
