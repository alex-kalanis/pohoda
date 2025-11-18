<?php

namespace tests\AttributesTests\Processing;

use kalanis\Pohoda\Common\Dtos\Processing;
use tests\AttributesTests\XExampleDto;
use tests\CommonTestClass;

class ReferencedAttrTest extends CommonTestClass
{
    public function testGetOptionsBasic(): void
    {
        $result = Processing::getRefAttributes(new XExampleDto(), false);
        $this->assertEquals([
            'referenceAsString',
            'referenceAsArray',
        ], $result);
    }

    public function testGetOptionsDirections(): void
    {
        $result = Processing::getRefAttributes(new XExampleDto(), true);
        $this->assertEquals([
            'referenceAsString',
            'referenceAsArray',
            'referencedResponse',
        ], $result);
    }
}
