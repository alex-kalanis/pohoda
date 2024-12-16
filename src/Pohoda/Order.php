<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\Common\AddActionTypeTrait;


class Order extends AbstractDocument
{
    use AddActionTypeTrait;

    public function getImportRoot(): string
    {
        return 'lst:order';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentElements(): array
    {
        return \array_merge(parent::getDocumentElements(), ['actionType']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'ord';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'order';
    }
}
