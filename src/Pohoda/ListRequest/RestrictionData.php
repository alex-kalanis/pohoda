<?php

declare(strict_types=1);

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class RestrictionData extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:restrictionData', '', $this->namespace('lst'));

        $this->addElements($xml, $this->getDataElements(), 'lst');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new RestrictionDataDto();
    }
}
