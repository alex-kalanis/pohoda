<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

trait DirectionAsResponseTrait
{
    protected bool $directionAsResponse = false;

    public function setDirectionAsResponse(bool $value): self
    {
        $this->directionAsResponse = $value;
        return $this;
    }
}
