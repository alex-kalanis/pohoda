<?php

namespace tests\BasicTests;

use tests\CommonTestClass;
use LogicException;

class ActionTypeTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new XActionType();
        $lib->addActionType('add');
        $this->assertTrue(isset($lib->data['actionType']));
    }

    public function testRepeat(): void
    {
        $lib = new XActionType();
        $this->assertNotEmpty($lib->addActionType('add'));
        $this->expectException(LogicException::class);
        $lib->addActionType('delete');
    }
}
