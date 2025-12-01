<?php

namespace tests\AgendaTests\Type;

use kalanis\PohodaException;
use tests\CommonTestClass;
use kalanis\Pohoda\Type;

class ActionTypeTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $dto = new Type\Dtos\ActionTypeDto();
        $dto->type = 'add';

        $lib = new Type\ActionType($this->getBasicDi());
        $this->expectException(PohodaException::class);
        $lib->setData($dto)->getXML();
    }

    public function testUpdateParams(): void
    {
        $dto = new Type\Dtos\ActionTypeDto();
        $dto->type = 'add/update';

        $lib = new Type\ActionType($this->getBasicDi());
        $lib->setResolveOptions(false);
        $lib->setNamespace('lst');
        $this->assertEquals('', $lib->setData($dto)->getXML());
    }
}
