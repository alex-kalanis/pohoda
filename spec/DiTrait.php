<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia;

use Riesenia\Pohoda;

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
