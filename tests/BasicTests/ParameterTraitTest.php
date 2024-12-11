<?php

namespace BasicTests;

use CommonTestClass;
use Riesenia\Pohoda\Common\AddParameterTrait;


class ParameterTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new XParameter();
        $lib->addParameter('foo', 'text', 'baz');
        $this->assertTrue(isset($lib->data['parameters']));
    }

    public function testRepeat(): void
    {
        $lib = new XParameter();
        $lib->addParameter('foo', 'text', 'baz');
        $lib->addParameter('bar', 'number', '123');
        $this->assertNotEmpty($lib->data);
        $this->assertTrue(isset($lib->data['parameters']));
        $this->assertEquals(2, count($lib->data['parameters']));
    }
}


class XParameter
{
    use AddParameterTrait;

    public array $data = [];
    protected string $ico = 'dummy';
}