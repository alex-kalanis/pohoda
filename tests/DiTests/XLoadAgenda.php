<?php

namespace kalanis\Pohoda;

class XAgenda extends AbstractAgenda
{
    public function __construct() {}

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('mock');
    }

    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Common\Dtos\EmptyDto();
    }
}

namespace tests\DiTests;

class XLoadAgenda
{
    public static function init(): void {}
}
