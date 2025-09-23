<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use DomainException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\PrintRequest;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class ParameterFactoryTest extends CommonTestClass
{
    public function testPass(): void
    {
        $lib = new PrintRequest\ParameterFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $this->assertInstanceOf(PrintRequest\Parameter::class, $lib->getByKey('text1'));
    }

    public function testNotSet(): void
    {
        $lib = new PrintRequest\ParameterFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $this->expectException(DomainException::class);
        $lib->getByKey('this does not exists');
    }

    public function testNotCreated(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $this->expectException(DomainException::class);
        $lib->getByKey('just_standard');
    }

    public function testNotInstance(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $this->expectException(DomainException::class);
        $lib->getByKey('not_instance');
    }
}
