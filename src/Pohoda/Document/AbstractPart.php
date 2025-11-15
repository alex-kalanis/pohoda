<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Document;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\SetNamespaceTrait;

abstract class AbstractPart extends AbstractAgenda
{
    use SetNamespaceTrait;

    protected ?string $nodePrefix = null;

    /**
     * Set node name prefix.
     *
     * @param string $prefix
     *
     * @return void
     */
    public function setNodePrefix(string $prefix): void
    {
        $this->nodePrefix = $prefix;
    }
}
