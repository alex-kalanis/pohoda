<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

trait OneDirectionalVariablesTrait
{

    protected bool $useOneDirectionalVariables = false;

    public function setDirectionalVariable(bool $value): self
    {
        $this->useOneDirectionalVariables = $value;
        return $this;
    }
}
