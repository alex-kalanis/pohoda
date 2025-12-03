<?php

namespace tests\BasicTests;

use tests\CommonTestClass;
use kalanis\Pohoda\Type\Enums\ParameterTypeEnum;

class ParameterTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new XParameter();
        $lib->addParameter('foo', ParameterTypeEnum::Text, 'baz');
        $this->assertTrue(isset($lib->data->parameters));
    }

    public function testRepeat(): void
    {
        $lib = new XParameter();
        $lib->addParameter('foo', 'text', 'baz');
        $lib->addParameter('bar', ParameterTypeEnum::Number, '123');
        $this->assertNotEmpty($lib->data);
        $this->assertTrue(isset($lib->data->parameters));
        $this->assertEquals(2, count($lib->data->parameters));
    }
}
