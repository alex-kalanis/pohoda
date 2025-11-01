<?php

namespace tests\DiTests;

use Riesenia\Pohoda;
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
        $this->expectException(\DomainException::class);
        $lib->getAgenda('thisDoesNotExists');
    }

    public function testInitFailed(): void
    {
        $lib = $this->getLib(true);
        $this->expectException(\DomainException::class);
        $lib->getAgenda('XAgenda');
    }

    public function testNotAgenda(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
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
