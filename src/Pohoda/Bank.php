<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

class Bank extends AbstractDocument
{

    public static string $importRoot = 'lst:bank';

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'bnk';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'bank';
    }
}
