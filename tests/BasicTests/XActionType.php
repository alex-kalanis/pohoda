<?php

namespace tests\BasicTests;

use Riesenia\Pohoda\Common\AddActionTypeTrait;
use Riesenia\Pohoda\Common\OneDirectionalVariablesTrait;
use Riesenia\Pohoda\DI\DependenciesFactory;

class XActionType
{
    use AddActionTypeTrait;
    use OneDirectionalVariablesTrait;

    public array $data = [];
    protected bool $resolveOptions = false;
    protected readonly DependenciesFactory $dependenciesFactory;

    public function __construct()
    {
        $this->dependenciesFactory = new DependenciesFactory();
    }
}
