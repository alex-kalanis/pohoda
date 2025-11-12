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

/**
 * @property Order\OrderDto $data
 */
class Order extends AbstractDocument
{
    use AddActionTypeTrait;

    public function getImportRoot(): string
    {
        return 'lst:order';
    }

    protected function getDocumentNamespace(): string
    {
        return 'ord';
    }

    protected function getDocumentName(): string
    {
        return 'order';
    }

    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Order\OrderDto();
    }
}
