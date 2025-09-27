<?php

namespace Riesenia\Pohoda\DI;

trait ClassNameTrait
{
    public function getClassName(string $name): string
    {
        $namespaceSub = explode('\\', __NAMESPACE__);
        $namespaceSub = array_slice($namespaceSub, 0, -1);
        return implode('\\', $namespaceSub) . '\\' . $name;
    }
}
