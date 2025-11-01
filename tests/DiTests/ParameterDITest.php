<?php

namespace tests\DiTests;

use Riesenia\Pohoda;
use tests\CommonTestClass;

class ParameterDITest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\PrintRequest\Parameter::class, $lib->getByClassName(Pohoda\XParameter::class));
    }

    public function testNotDefined(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getByClassName('thisDoesNotExists');
    }

    public function testInitFailed(): void
    {
        $lib = $this->getLib(true);
        $this->expectException(\DomainException::class);
        $lib->getByClassName(Pohoda\XParameter::class);
    }

    public function testNotAgenda(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getByClassName(Pohoda\XClass::class);
    }

    protected function getLib(bool $killGet = false): Pohoda\DI\ParameterDIFactory
    {
        // just load that classes - and that files!
        XLoadParameter::init();
        XLoadOther::init();
        return new Pohoda\DI\ParameterDIFactory((new TestingContainer([
            new Pohoda\XParameter(),
            new Pohoda\XClass(),
        ]))->setKillGet($killGet));
    }
}
