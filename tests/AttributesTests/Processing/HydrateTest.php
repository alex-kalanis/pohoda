<?php

namespace tests\AttributesTests\Processing;

use kalanis\Pohoda\Common\Dtos\Processing;
use tests\AttributesTests\XSimpleDto;
use tests\CommonTestClass;

class HydrateTest extends CommonTestClass
{
    public function testBasic(): void
    {
        $result = Processing::hydrate(new XSimpleDto(), [
            'withoutAttributes' => 'this one is without attrs',
            'integer' => 123456,
            'float' => 123.456,
            'shortString' => 'nopenopenope',
            'someDate' => date_create_immutable('2025-11-17 13:37:00'),
            'someBoolean' => true,
            'listOfOptions' => 'none',
            'internal' => 456789,
            'justAttribute' => 789123,
            'responseInteger' => 147259,
            'redirectToDifferentOne' => 258369,
        ], false);

        $this->assertInstanceOf(XSimpleDto::class, $result);
        $this->assertEquals('this one is without attrs', $result->withoutAttributes);
        $this->assertEquals(123456, $result->integer);
        $this->assertEquals(123.456, $result->float);
        $this->assertEquals('nopenopenope', $result->shortString);
        $this->assertEquals(date_create_immutable('2025-11-17 13:37:00'), $result->someDate);
        $this->assertEquals(true, $result->someBoolean);
        $this->assertEquals('none', $result->listOfOptions);
        $this->assertNull($result->internal); // skip, do not fill
        $this->assertEquals(789123, $result->justAttribute); // pass data, but not render anything
        $this->assertNull($result->responseInteger); // this one is filled only when flagged responses are wanted
        $this->assertNull($result->redirectToDifferentOne);
        $this->assertEquals(258369, $result->willBeSkipped);
    }

    public function testWithResponseDirection(): void
    {
        $result = Processing::hydrate(new XSimpleDto(), [
            'withoutAttributes' => 'this one is without attrs',
            'integer' => 123456,
            'float' => 123.456,
            'shortString' => 'nopenopenope',
            'someDate' => date_create_immutable('2025-11-17 13:37:00'),
            'someBoolean' => true,
            'listOfOptions' => 'none',
            'internal' => 456789,
            'justAttribute' => 789123,
            'responseInteger' => 147259,
            'redirectToDifferentOne' => 258369,
        ], true);

        $this->assertInstanceOf(XSimpleDto::class, $result);
        $this->assertEquals('this one is without attrs', $result->withoutAttributes);
        $this->assertEquals(123456, $result->integer);
        $this->assertEquals(123.456, $result->float);
        $this->assertEquals('nopenopenope', $result->shortString);
        $this->assertEquals(date_create_immutable('2025-11-17 13:37:00'), $result->someDate);
        $this->assertEquals(true, $result->someBoolean);
        $this->assertEquals('none', $result->listOfOptions);
        $this->assertNull($result->internal); // skip, do not fill
        $this->assertEquals(789123, $result->justAttribute); // pass data, but not render anything
        $this->assertEquals(147259, $result->responseInteger); // this one is filled only when flagged responses are wanted
        $this->assertNull($result->redirectToDifferentOne);
        $this->assertEquals(258369, $result->willBeSkipped);
    }

    public function testMultiDirection(): void
    {
        $result = Processing::hydrate(new XSimpleDto(), [
            'redirectToMultipleDifferent' => 4864615,
        ], false);

        $this->assertInstanceOf(XSimpleDto::class, $result);
        $this->assertNull($result->redirectToDifferentOne);
        $this->assertNull($result->redirectToMultipleDifferent);
        $this->assertNull($result->willBeSkipped);
        $this->assertEquals(4864615, $result->willBeSkipped2);
        $this->assertEquals(4864615, $result->willBeSkipped3);
    }

    public function testExtraProps(): void
    {
        $dto = new XSimpleDto();
        $dto->extra1 = null;
        $dto->extra3 = null;
        $dto->extra5 = null;
        $dto->extra7 = 'baz';
        $dto->extra9 = 'foo';
        $result = Processing::hydrate($dto, [
            'extra1' => 849613,
            'extra2' => 186135,
            'extra3' => 'foo',
            'extra4' => 'bar',
            'extra9' => null,
        ], false);

        $this->assertInstanceOf(XSimpleDto::class, $result);
        $this->assertEquals(849613, $result->extra1);
        $this->assertEquals('foo', $result->extra3);
        $this->assertNull($result->extra5);
        $this->assertEquals('baz', $result->extra7);
        $this->assertEquals('foo', $result->extra9); // you cannot delete with hydrate - limitation of PHP
    }
}
