<?php

namespace Riesenia\Pohoda\DI;

use Riesenia\Pohoda\PrintRequest;

interface ParameterFactoryInterface
{
    /**
     * @param class-string<PrintRequest\Parameter> $className
     * @return PrintRequest\Parameter
     */
    public function getByClassName(string $className): PrintRequest\Parameter;
}
