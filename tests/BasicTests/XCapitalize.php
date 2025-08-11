<?php

namespace tests\BasicTests;

use Riesenia\Pohoda;

class XCapitalize implements Pohoda\ValueTransformer\ValueTransformerInterface
{
    public function transform(string $value): string
    {
        return \strtoupper($value);
    }
}
