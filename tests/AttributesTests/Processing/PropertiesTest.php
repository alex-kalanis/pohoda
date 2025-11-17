<?php

namespace tests\AttributesTests\Processing;

use Riesenia\Pohoda\Common\Dtos\Processing;
use tests\AttributesTests\XExampleDto;
use tests\CommonTestClass;

class PropertiesTest extends CommonTestClass
{
    public function testGetOptionsBasic(): void
    {
        $result = Processing::getProperties(new XExampleDto(), false, false);
        $this->assertEquals([
            'withoutAttributes',
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
            'referenceAsString',
            'referenceAsArray',
            'currency',
            'redirectToDifferentOne',
            'parameters',
        ], $result);
    }

    public function testGetOptionsDirections(): void
    {
        $result = Processing::getProperties(new XExampleDto(), false, true);
        $this->assertEquals([
            'withoutAttributes',
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
            'referenceAsString',
            'referenceAsArray',
            'responseInteger',
            'referencedResponse',
            'currency',
            'redirectToDifferentOne',
            'parameters',
        ], $result);
    }

    public function testGetWithAttributes(): void
    {
        $result = Processing::getProperties(new XExampleDto(), true, false);
        $this->assertEquals([
            'withoutAttributes',
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
            'referenceAsString',
            'referenceAsArray',
            'justAttribute',
            'currency',
            'redirectToDifferentOne',
            'parameters',
        ], $result);
    }

    public function testGetWithAttributesOptionsDirections(): void
    {
        $result = Processing::getProperties(new XExampleDto(), true, true);
        $this->assertEquals([
            'withoutAttributes',
            'integer',
            'float',
            'shortString',
            'longString',
            'someDate',
            'someBoolean',
            'listOfOptions',
            'referenceAsString',
            'referenceAsArray',
            'justAttribute',
            'responseInteger',
            'referencedResponse',
            'currency',
            'redirectToDifferentOne',
            'parameters',
        ], $result);
    }
}
