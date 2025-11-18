<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

trait DirectionAsResponseTrait
{
    protected bool $directionAsResponse = false;

    public function setDirectionAsResponse(bool $value): self
    {
        $this->directionAsResponse = $value;
        return $this;
    }
}
