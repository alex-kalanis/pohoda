<?php

namespace Riesenia\Pohoda;

class XAgenda extends AbstractAgenda
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

class XLoadAgenda
{
    public static function init(): void
    {
    }
}
