<?php

namespace tests\AgendaTests\Type;

use kalanis\Pohoda;
use tests\CommonTestClass;
use DomainException;

class ParameterFactoryTest extends CommonTestClass
{
    public function testPass(): void
    {
        $lib = $this->getBasicDi();
        $this->assertInstanceOf(Pohoda\PrintRequest\Parameter::class, $lib->getParametersFactory()->getByClassName($lib->getParameterInstances()->getByKey('text1')));
    }

    public function testNotSet(): void
    {
        $lib = $this->getBasicDi();
        $this->expectException(DomainException::class);
        $lib->getParametersFactory()->getByClassName($lib->getParameterInstances()->getByKey('this does not exists'));
    }

    public function testNotCreated(): void
    {
        $lib = new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
            new Pohoda\Common\OptionsResolver\Normalizers\NormalizerFactory(),
            null,
            new XParamInstances(),
        );
        $this->expectException(DomainException::class);
        $lib->getParametersFactory()->getByClassName($lib->getParameterInstances()->getByKey('just_standard'));
    }

    public function testNotInstance(): void
    {
        $lib = new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
            new Pohoda\Common\OptionsResolver\Normalizers\NormalizerFactory(),
            null,
            new XParamInstances(),
        );
        $this->expectException(DomainException::class);
        $lib->getParametersFactory()->getByClassName($lib->getParameterInstances()->getByKey('not_instance'));
    }
}
