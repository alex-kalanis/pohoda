<?php

namespace kalanis\Pohoda;

class XParameter extends PrintRequest\Parameter
{
    public function __construct() {}

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('mock');
    }
}

namespace tests\DiTests;

class XLoadParameter
{
    public static function init(): void {}
}
