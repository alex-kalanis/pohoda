<?php

namespace tests\DiTests;

use Riesenia\Pohoda;
use tests\CommonTestClass;

class DocumentPartDITest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib->getPart('Riesenia\Pohoda', 'XDocument'));
    }

    public function testNotDefined(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getPart('ignore', 'thisDoesNotExists');
    }

    public function testInitFailed(): void
    {
        $lib = $this->getLib(true);
        $this->expectException(\DomainException::class);
        $lib->getPart('Riesenia\Pohoda', 'XDocument');
    }

    public function testNotAgenda(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getPart('Riesenia\Pohoda', 'XClass');
    }

    protected function getLib(bool $killGet = false): Pohoda\DI\DocumentPartDIFactory
    {
        // just load that classes - and that files!
        XLoadAbstract::init();
        XLoadOther::init();
        return new Pohoda\DI\DocumentPartDIFactory((new TestingContainer([
            new Pohoda\XDocument(),
            new Pohoda\XClass(),
        ]))->setKillGet($killGet));
    }
}
