<?php

namespace tests\AgendaTests;

use kalanis\PohodaException;
use tests\CommonTestClass;
use kalanis\Pohoda;

class ActionPriceTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\ActionPrice::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:actionPrice', $lib->getImportRoot());
        $lib->setData(new Pohoda\Common\Dtos\EmptyDto());
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $this->expectException(PohodaException::class);
        $lib->getXML();
    }

    protected function getLib(): Pohoda\ActionPrice
    {
        return new Pohoda\ActionPrice($this->getBasicDi());
    }
}
