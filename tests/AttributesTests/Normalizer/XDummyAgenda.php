<?php

namespace tests\AttributesTests\Normalizer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use SimpleXMLElement;
use tests\AttributesTests\XSimpleDto;

class XDummyAgenda extends AbstractAgenda
{
    public function getXML(): SimpleXMLElement
    {
        return new SimpleXMLElement('mock');
    }

    public function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new XSimpleDto();
    }
}
