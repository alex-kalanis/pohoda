<?php

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\PrintRequest;

interface ParameterFactoryInterface
{
    /**
     * @param class-string<PrintRequest\Parameter> $className
     * @return PrintRequest\Parameter
     */
    public function getByClassName(string $className): PrintRequest\Parameter;
}
