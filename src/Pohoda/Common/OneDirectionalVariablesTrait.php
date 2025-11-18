<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

trait OneDirectionalVariablesTrait
{
    protected bool $useOneDirectionalVariables = false;

    public function setDirectionalVariable(bool $value): self
    {
        $this->useOneDirectionalVariables = $value;
        return $this;
    }
}
