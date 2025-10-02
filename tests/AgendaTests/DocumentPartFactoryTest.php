<?php

namespace tests\AgendaTests;

use DomainException;
use Riesenia\Pohoda;
use tests\CommonTestClass;

class DocumentPartFactoryTest extends CommonTestClass
{
    public function testSuccess(): void
    {
        $lib = new Pohoda\DI\DocumentPartReflectFactory($this->getBasicDi());
        $this->assertInstanceOf(Pohoda\Document\AbstractPart::class, $lib->getPart('Riesenia\Pohoda\Bank', 'Summary'));
    }

    public function testNonExistingEntity(): void
    {
        // this thing is ignored by phpstan, but called here
        $lib = new Pohoda\DI\DocumentPartReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Entity does not exists: ');
        $this->expectException(DomainException::class);
        $lib->getPart('this_class_does_not_exists', 'anywhere');
    }

    public function testAbstractEntity(): void
    {
        $lib = new Pohoda\DI\DocumentPartReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Entity cannot be initialized: ');
        $this->expectException(DomainException::class);
        $lib->getPart('Riesenia\Pohoda\Document', 'AbstractHeader');
    }

    public function testBadConstructEntity(): void
    {
        $lib = new Pohoda\DI\DocumentPartReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Entity cannot be initialized: XDocPartNotInit');
        $this->expectException(DomainException::class);
        $lib->getPart(__NAMESPACE__, 'XDocPartNotInit');
    }

    public function testEntityNotInstance(): void
    {
        $lib = new Pohoda\DI\DocumentPartReflectFactory($this->getBasicDi());
        $this->expectExceptionMessage('Entity is not an instance of AbstractPart: ');
        $this->expectException(DomainException::class);
        $lib->getPart(__NAMESPACE__, 'XDocPartNotInstance');
    }
}
