<?php

namespace tests\AttributesTests\Processing;

use kalanis\Pohoda\Common\Dtos\Processing;
use tests\AttributesTests\XExampleDto;
use tests\CommonTestClass;

class OptionsTest extends CommonTestClass
{
    public function testGetOptionsBasic(): void
    {
        $result = Processing::getOptions(new XExampleDto(), false);
        $this->assertEquals([
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
        ], array_keys($result));
    }

    public function testGetOptionsDirections(): void
    {
        $result = Processing::getOptions(new XExampleDto(), true);
        $this->assertEquals([
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
            'responseInteger',
        ], array_keys($result));
    }
}
