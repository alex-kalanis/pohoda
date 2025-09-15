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
        $lib = new PrintRequest\ParameterFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->assertInstanceOf(PrintRequest\Parameter::class, $lib->getByKey('text1', false));
    }

    public function testNotSet(): void
    {
        $lib = new PrintRequest\ParameterFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('this does not exists', false);
    }

    public function testNotCreated(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('just_standard', false);
    }

    public function testNotInstance(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('not_instance', false);
    }
}
