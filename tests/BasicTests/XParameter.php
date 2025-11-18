<?php

namespace tests\BasicTests;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\DI\DependenciesFactory;

class XParameter
{
    use Common\AddParameterTrait;
    use Common\OneDirectionalVariablesTrait;

    public Common\Dtos\AbstractDto $data;
    protected bool $resolveOptions = false;
    protected readonly DependenciesFactory $dependenciesFactory;

    public function __construct()
    {
        $this->dependenciesFactory = new DependenciesFactory();
        $this->data = new XParameterDto();
    }
}
