<?php

namespace tests\BasicTests;

use kalanis\PohodaException;
use tests\CommonTestClass;

class ActionTypeTraitTest extends CommonTestClass
{
    /**
     * @throws PohodaException
     * @return void
     */
    public function testOk(): void
    {
        $lib = new XActionType();
        $lib->addActionType('add');
        $this->assertTrue(isset($lib->data->actionType));
    }

    /**
     * @throws PohodaException
     * @return void
     */
    public function testRepeat(): void
    {
        $lib = new XActionType();
        $lib->addActionType('add');
        $this->assertTrue(isset($lib->data->actionType));
        $this->expectException(PohodaException::class);
        $lib->addActionType('delete');
    }
}
