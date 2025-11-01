<?php

namespace Riesenia\Pohoda;

class XDocument extends Document\AbstractPart
{
    public function __construct()
    {
    }

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('mock');
    }

    protected function configureOptions(Common\OptionsResolver $resolver): void
    {}
}

namespace tests\DiTests;

class XLoadAbstract
{
    public static function init(): void
    {
    }
}
