<?php

// intentionally another namespace here - I need to mock few classes for testing

namespace Riesenia\Pohoda;

class XAgendaNotInit extends AbstractAgenda
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
    }

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('nop');
    }

    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Common\Dtos\EmptyDto();
    }
}


class XAgendaNotInstance
{
    public function __construct(object $obj1) {}
}


// now test part

namespace tests\AgendaTests;

use DomainException;
use Riesenia\Pohoda;
use tests\CommonTestClass;

class AgendaFactoryTest extends CommonTestClass
{
    public function testSuccess(): void
    {
        $lib = new Pohoda\DI\AgendaReflectFactory($this->getBasicDi());
        $agenda = $lib->getAgenda('Bank');
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $agenda);
        $this->assertFalse($agenda->canImportRecursive());
    }

    public function testNonExistingEntity(): void
    {
        // this thing is ignored by phpstan, but called here
        $lib = new Pohoda\DI\AgendaReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Agenda class does not exists: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('this_class_does_not_exists');
    }

    public function testAbstractEntity(): void
    {
        $lib = new Pohoda\DI\AgendaReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Agenda class cannot be initialized: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('AbstractDocument');
    }

    public function testBadConstructEntity(): void
    {
        $lib = new Pohoda\DI\AgendaReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Agenda class cannot be initialized: XAgendaNotInit');
        $this->expectException(DomainException::class);
        $lib->getAgenda('XAgendaNotInit');
    }

    public function testEntityNotInstance(): void
    {
        $lib = new Pohoda\DI\AgendaReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Agenda class is not an instance of AbstractAgenda: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('XAgendaNotInstance');
    }
}
