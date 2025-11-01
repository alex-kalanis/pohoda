<?php

namespace Riesenia\Pohoda\DI;

trait ClassNameTrait
{
    /**
     * @param string|class-string $name
     * @return class-string
     * The difference in absolute-relative paths are signalized by slash in the beginning of string
     */
    public function getClassName(string $name): string
    {
        $namespaceSub = explode('\\', __NAMESPACE__);
        $namespaceSub = array_slice($namespaceSub, 0, -1);
        $namespaceSub = implode('\\', $namespaceSub);

        if (str_starts_with($name, '\\')) {
            // absolute path
            return substr($name, 1);
        }

        if (str_starts_with($name, $namespaceSub)) {
            return $name;
        }

        return $namespaceSub . '\\' . $name;
    }
}
