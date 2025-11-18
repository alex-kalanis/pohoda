<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

use kalanis\Pohoda\Common\AddActionTypeTrait;

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
