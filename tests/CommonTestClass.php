<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use Riesenia\Pohoda;

/**
 * Class CommonTestClass
 * The structure for mocking and configuration seems so complicated, but it's necessary to let it be totally idiot-proof
 */
class CommonTestClass extends TestCase
{
    protected function getBasicDi(): Pohoda\DI\DependenciesFactory
    {
        return new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
            new Pohoda\Common\OptionsResolver\Normalizers\NormalizerFactory(),
            null,
            new Pohoda\PrintRequest\ParameterInstances(),
        );
    }
}
