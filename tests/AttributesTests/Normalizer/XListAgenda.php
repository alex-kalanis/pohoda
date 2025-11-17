<?php

namespace tests\AttributesTests\Normalizer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use SimpleXMLElement;
use tests\AttributesTests\XRequestDto;

class XListAgenda extends AbstractAgenda
{
    public function getXML(): SimpleXMLElement
    {
        return new SimpleXMLElement('mock');
    }

    public function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new XRequestDto();
    }
}
