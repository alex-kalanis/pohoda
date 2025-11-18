<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\Pohoda\AbstractAgenda;

class SharedResolver
{
    /** @var OptionsResolver[] */
    private static array $resolvers = [];

    /**
     * Get correct resolver
     *
     * @param AbstractAgenda $class
     * @param bool $directional
     * @param array<string,mixed> $data
     *
     * @return OptionsResolver
     */
    public static function getResolver(AbstractAgenda $class, bool $directional, array $data): OptionsResolver
    {
        $key = \get_class($class) . '_' . \intval($directional) . '__' . \implode('_', \array_keys($data));

        if (!isset(self::$resolvers[$key])) {
            self::$resolvers[$key] = new OptionsResolver();
        }

        return self::$resolvers[$key];
    }
}
