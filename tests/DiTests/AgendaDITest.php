<?php

namespace tests\DiTests;

use kalanis\Pohoda;
use kalanis\PohodaException;
use tests\CommonTestClass;

class AgendaDITest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib->getAgenda('XAgenda'));
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib->getAgenda(Pohoda\XAgenda::class));
    }

    public function testNotDefined(): void
    {
        $lib = $this->getLib();
        $this->expectException(PohodaException::class);
        $lib->getAgenda('thisDoesNotExists');
    }

    public function testInitFailed(): void
    {
        $lib = $this->getLib(true);
        $this->expectException(PohodaException::class);
        $lib->getAgenda('XAgenda');
    }

    public function testNotAgenda(): void
    {
        $lib = $this->getLib();
        $this->expectException(PohodaException::class);
        $lib->getAgenda('XClass');
    }

    protected function getLib(bool $killGet = false): Pohoda\DI\AgendaDIFactory
    {
        // just load that classes - and that files!
        XLoadAgenda::init();
        XLoadOther::init();
        return new Pohoda\DI\AgendaDIFactory((new TestingContainer([
            new Pohoda\XAgenda(),
            new Pohoda\XClass(),
        ]))->setKillGet($killGet));
    }
}
