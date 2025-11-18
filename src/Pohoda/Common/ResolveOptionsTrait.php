<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

trait ResolveOptionsTrait
{
    protected bool $resolveOptions = true;

    public function setResolveOptions(bool $value): self
    {
        $this->resolveOptions = $value;
        return $this;
    }
}
