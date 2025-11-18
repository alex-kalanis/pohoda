<?php

declare(strict_types=1);

namespace kalanis\Pohoda\ValueTransformer;

interface ValueTransformerInterface
{
    /**
     * Transform data in xml nodes.
     *
     * @param string $value
     */
    public function transform(string $value): string;
}
