<?php

namespace tests\BasicTests;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\DI\DependenciesFactory;
use Riesenia\Pohoda\Type;

class XActionType
{
    use Common\AddActionTypeTrait;
    use Common\OneDirectionalVariablesTrait;

    public Common\Dtos\AbstractDto $data;
    protected bool $resolveOptions = false;
    protected readonly DependenciesFactory $dependenciesFactory;

    public function __construct()
    {
        $this->dependenciesFactory = new DependenciesFactory();
        $this->data = new Type\Dtos\ActionTypeDto();
    }
}
