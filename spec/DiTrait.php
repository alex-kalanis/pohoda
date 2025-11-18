<?php

declare(strict_types=1);

namespace spec\kalanis;

use kalanis\Pohoda;

trait DiTrait
{
    protected function getBasicDi(?Pohoda\ValueTransformer\SanitizeEncoding $sanitize = null): Pohoda\DI\DependenciesFactory
    {
        return new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            $sanitize ?? new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
            new Pohoda\Common\OptionsResolver\Normalizers\NormalizerFactory(),
            null,
            new Pohoda\PrintRequest\ParameterInstances(),
        );
    }
}
