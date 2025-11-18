<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Document;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common\SetNamespaceTrait;

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
