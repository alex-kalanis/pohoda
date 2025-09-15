<?php

namespace Riesenia\Pohoda;

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
}
