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
