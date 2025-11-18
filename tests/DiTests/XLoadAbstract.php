<?php

namespace kalanis\Pohoda;

class XDocument extends Document\AbstractPart
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

class XLoadAbstract
{
    public static function init(): void {}
}
