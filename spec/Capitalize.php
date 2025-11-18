<?php

declare(strict_types=1);

namespace spec\kalanis;

use kalanis\Pohoda;

class Capitalize implements Pohoda\ValueTransformer\ValueTransformerInterface
{
    public function transform(string $value): string
    {
        return \strtoupper($value);
    }
}
