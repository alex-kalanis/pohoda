<?php

namespace AgendaTests\Type;


use CommonTestClass;
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
        $this->assertInstanceOf(PrintRequest\Parameter::class, $lib->getByKey('text1', [], false));
    }

    public function testNotSet(): void
    {
        $lib = new PrintRequest\ParameterFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('this does not exists', [], false);
    }

    public function testNotCreated(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('just_standard', [], false);
    }

    public function testNotInstance(): void
    {
        $lib = new XParamFactory(new NamespacesPaths(), new SanitizeEncoding(new Listing()), 'foo');
        $this->expectException(DomainException::class);
        $lib->getByKey('not_instance', [], false);
    }
}


class XFailClass
{
    public function __construct(
        object $obj1,
        object $obj2,
        array $arr,
        string $str,
        bool $bool,
    )
    {
    }
}


class XParamFactory extends PrintRequest\ParameterFactory
{
    protected array $instances = [
        'just_standard' => \stdClass::class,
        'not_instance' => XFailClass::class,
    ];
}

