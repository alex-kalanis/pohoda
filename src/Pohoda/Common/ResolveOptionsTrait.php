<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

trait ResolveOptionsTrait
{
    protected bool $resolveOptions = true;

    public function setResolveOptions(bool $value): self
    {
        $this->resolveOptions = $value;
        return $this;
    }
}
