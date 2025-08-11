<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\Type\Parameter;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class ParameterTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib([], false);
        $this->assertInstanceOf(Parameter::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertNull($lib->getImportRoot());
    }

    public function testCreateCorrectXml1(): void
    {
        $this->assertEquals('<typ:parameter><typ:name>VPr_testing</typ:name><typ:textValue>foo_bar_baz</typ:textValue></typ:parameter>', $this->getLib(
            [
                'name' => 'VPr_testing',
                'type' => 'text',
                'value' => 'foo_bar_baz',
            ]
        )->getXML()->asXML());
    }

    public function testCreateCorrectXml2(): void
    {
        $this->assertEquals('<typ:parameter><typ:name>RefVPrtesting</typ:name><typ:listValueRef><typ:ids>456</typ:ids></typ:listValueRef><typ:list><typ:0>statementNumber</typ:0><typ:1>numberMovement</typ:1></typ:list></typ:parameter>', $this->getLib(
            [
                'name' => 'testing',
                'type' => 'list',
                'value' => '456',
                'list' => [
                    'statementNumber',
                    'numberMovement',
                ],
            ]
        )->getXML()->asXML());
    }

    public function testCreateCorrectXml3(): void
    {
        $sanitize = new SanitizeEncoding(new Listing());
        $sanitize->willBeSanitized(true);
        $lib = new Parameter(
            new Pohoda\Common\NamespacesPaths(),
            $sanitize,
            [
                'name' => 'testing',
                'type' => 'list',
                'value' => '456',
                'list' => [
                    '123',
                    '456',
                    '789',
                ],
            ],
            '123',
        );
        $this->assertEquals('<typ:parameter><typ:name>RefVPrtesting</typ:name><typ:listValueRef><typ:ids>456</typ:ids></typ:listValueRef><typ:list><typ:0>123</typ:0><typ:1>456</typ:1><typ:2>789</typ:2></typ:list></typ:parameter>', $lib->getXML()->asXML());
    }

    public function testParamDateTime(): void
    {
        $lib = $this->getLib([
            'name' => 'bar',
            'type' => 'datetime',
            'value' => '2024-05-25',
        ]);
        $this->assertEquals('', $lib->getXML());
    }

    protected function getLib(array $params, bool $resolve = true): Parameter
    {
        return new Parameter(
            new Pohoda\Common\NamespacesPaths(),
            new SanitizeEncoding(new Listing()),
            $params,
            '123',
            $resolve,
        );
    }
}
