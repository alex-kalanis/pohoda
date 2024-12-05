<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

class CashSlip extends AbstractDocument
{

    public static string $importRoot = 'lst:prodejka';

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
}
