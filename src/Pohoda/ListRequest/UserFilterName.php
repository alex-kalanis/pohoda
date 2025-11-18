<?php

declare(strict_types=1);

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class UserFilterName extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $filterName = $this->data->userFilterName ?? null;
        return $this->createXML()->addChild(
            'ftr:userFilterName',
            is_null($filterName) ? null : strval($filterName),
            $this->namespace('ftr'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new UserFilterNameDto();
    }
}
