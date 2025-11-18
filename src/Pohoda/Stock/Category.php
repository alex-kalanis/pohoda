<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class Category extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $category = $this->data->idCategory ?? null;
        return $this->createXML()->addChild(
            'stk:idCategory',
            is_null($category) ? null : strval($category),
            $this->namespace('stk'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new CategoryDto();
    }
}
