<?php

namespace AgendaTests\Type;


use CommonTestClass;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Type\Parameter;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class ParameterTest extends CommonTestClass
{
    public function testParamDateTime(): void
    {
        $lib = new Parameter(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [
            'name' => 'bar',
            'type' => 'datetime',
            'value' => '2024-05-25',
            ], 'foo');
        $this->assertEquals('', $lib->getXML());
    }
}
