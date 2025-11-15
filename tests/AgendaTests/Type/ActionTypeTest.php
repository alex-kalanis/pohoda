<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Type;

class ActionTypeTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $dto = new Type\Dtos\ActionTypeDto();
        $dto->type = 'add';

        $lib = new Type\ActionType($this->getBasicDi());
        $this->expectException(LogicException::class);
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
