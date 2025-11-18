<?php

declare(strict_types=1);

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class QueryFilter extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ftr:queryFilter', '', $this->namespace('ftr'));

        $this->addElements($xml, $this->getDataElements(), 'ftr');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new QueryFilterDto();
    }
}
