<?php

namespace Riesenia\Pohoda;

class Voucher extends Document
{

    /** @var string */
    public static $importRoot = 'vch:voucher';

    protected function _getDocumentNamespace(): string
    {
        return 'vch';
    }

    protected function _getDocumentName(): string
    {
        return 'voucher';
    }
}