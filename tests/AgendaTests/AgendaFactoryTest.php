<?php

// intentionally another namespace here - I need to mock few classes for testing
namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;


class XAgendaNotInit extends AbstractAgenda
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
        parent::__construct([], 'num');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    public function getXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('nop');
    }
}


class XAgendaNotInstance
{
    public function __construct(array $data, string $number, bool $opts = false)
    {
    }
}


// now test part
namespace AgendaTests;


use CommonTestClass;
use DomainException;
use Riesenia\Pohoda;


class AgendaFactoryTest extends CommonTestClass
{
    public function testSuccess(): void
    {
        $lib = new Pohoda\AgendaFactory('some no');
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib->getAgenda('Bank', []));
    }

    public function testNonExistingEntity(): void
    {
        // this thing is ignored by phpstan, but called here
        $lib = new Pohoda\AgendaFactory('some no');
        $this->expectExceptionMessage('Agenda class does not exists: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('this_class_does_not_exists', []);
    }

    public function testAbstractEntity(): void
    {
        $lib = new Pohoda\AgendaFactory('some no');
        $this->expectExceptionMessage('Agenda class cannot be initialized: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('AbstractDocument', []);
    }

    public function testBadConstructEntity(): void
    {
        $lib = new Pohoda\AgendaFactory('some no');
        $this->expectExceptionMessage('Agenda class cannot be initialized: XAgendaNotInit');
        $this->expectException(DomainException::class);
        $lib->getAgenda('XAgendaNotInit', []);
    }

    public function testEntityNotInstance(): void
    {
        $lib = new Pohoda\AgendaFactory('some no');
        $this->expectExceptionMessage('Agenda class is not an instance of AbstractAgenda: ');
        $this->expectException(DomainException::class);
        $lib->getAgenda('XAgendaNotInstance', []);
    }
}
