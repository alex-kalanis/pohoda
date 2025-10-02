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

class Capitalize implements Pohoda\ValueTransformer\ValueTransformerInterface
{
    public function transform(string $value): string
    {
        return \strtoupper($value);
    }
}
