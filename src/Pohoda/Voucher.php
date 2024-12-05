<?php

namespace Riesenia\Pohoda;

class Voucher extends AbstractDocument
{

    public static string $importRoot = 'vch:voucher';

    protected function getDocumentNamespace(): string
    {
        return 'vch';
    }

    protected function getDocumentName(): string
    {
        return 'voucher';
    }
}