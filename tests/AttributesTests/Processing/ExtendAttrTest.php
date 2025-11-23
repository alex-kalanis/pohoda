<?php

namespace AttributesTests\Processing;

use kalanis\Pohoda\Common\Dtos\Processing;
use tests\AttributesTests\XExtendDto;
use tests\CommonTestClass;

class ExtendAttrTest extends CommonTestClass
{
    public function testGetOptionsBasic(): void
    {
        $result = Processing::getAttributesExtendingElements(new XExtendDto(), false);
        $this->assertEquals([
            'dummyName1',
            'dummyName2',
        ], array_keys($result));
    }

    public function testGetOptionsDirections(): void
    {
        $result = Processing::getAttributesExtendingElements(new XExtendDto(), true);
        $this->assertEquals([
            'dummyName1',
            'dummyName2',
            'dummyName3',
        ], array_keys($result));
    }
}
