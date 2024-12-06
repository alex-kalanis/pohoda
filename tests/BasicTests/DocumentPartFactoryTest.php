<?php

namespace BasicTests;


use CommonTestClass;
use DomainException;
use Riesenia\Pohoda;
use Riesenia\Pohoda\Common\OptionsResolver;


class DocumentPartFactoryTest extends CommonTestClass
{
    public function testSuccess(): void
    {
        $lib = new Pohoda\DocumentPartFactory('some no');
        $this->assertInstanceOf(Pohoda\Document\AbstractPart::class, $lib->getPart('Riesenia\Pohoda\Bank', 'Summary', []));
    }

    public function testNonExistingEntity(): void
    {
        // this thing is ignored by phpstan, but called here
        $lib = new Pohoda\DocumentPartFactory('some no');
        $this->expectExceptionMessage('Entity does not exists: ');
        $this->expectException(DomainException::class);
        $lib->getPart('this_class_does_not_exists', 'anywhere', []);
    }

    public function testAbstractEntity(): void
    {
        $lib = new Pohoda\DocumentPartFactory('some no');
        $this->expectExceptionMessage('Entity cannot be initialized: ');
        $this->expectException(DomainException::class);
        $lib->getPart('Riesenia\Pohoda\Document', 'AbstractHeader', []);
    }

    public function testBadConstructEntity(): void
    {
        $lib = new Pohoda\DocumentPartFactory('some no');
        $this->expectExceptionMessage('Entity cannot be initialized: XDocPartNotInit');
        $this->expectException(DomainException::class);
        $lib->getPart('BasicTests', 'XDocPartNotInit', []);
    }

    public function testEntityNotInstance(): void
    {
        $lib = new Pohoda\DocumentPartFactory('some no');
        $this->expectExceptionMessage('Entity is not an instance of AbstractPart: ');
        $this->expectException(DomainException::class);
        $lib->getPart('BasicTests', 'XDocPartNotInstance', []);
    }
}


class XDocPartNotInit extends Pohoda\Document\AbstractPart
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
        parent::__construct([], 'num');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}


class XDocPartNotInstance
{
    public function __construct(array $data, string $number, bool $opts = false)
    {
    }
}
