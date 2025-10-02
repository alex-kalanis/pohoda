<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Type\ActionType;

class ActionTypeTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new ActionType($this->getBasicDi());
        $this->expectException(LogicException::class);
        $lib->setData(['type' => 'add'])->getXML();
    }

    public function testUpdateParams(): void
    {
        $lib = new ActionType($this->getBasicDi());
        $lib->setResolveOptions(false);
        $lib->setNamespace('lst');
        $this->assertEquals('', $lib->setData([
            'type' => 'add/update',
        ])->getXML());
    }
}
