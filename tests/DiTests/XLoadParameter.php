<?php

namespace Riesenia\Pohoda;

class XParameter extends PrintRequest\Parameter
{
    public function __construct() {}

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('mock');
    }

    protected function configureOptions(Common\OptionsResolver $resolver): void {}
}

namespace tests\DiTests;

class XLoadParameter
{
    public static function init(): void {}
}
