<?php

declare(strict_types=1);

namespace kalanis\Pohoda\ValueTransformer;

/**
 * A transformer that returns the input value unchanged.
 *
 * This transformer performs no modifications and simply passes the original value through.
 */
final class IdentityTransformer implements ValueTransformerInterface
{
    public function transform(string $value): string
    {
        return $value;
    }
}
