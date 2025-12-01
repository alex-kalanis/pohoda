<?php

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\PrintRequest;
use kalanis\PohodaException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

final class ParameterDIFactory implements ParameterFactoryInterface
{
    public function __construct(
        protected readonly ContainerInterface $container,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getByClassName(string $className): PrintRequest\Parameter
    {
        if (!$this->container->has($className)) {
            throw new PohodaException('Parameter Entity does not exists: ' . $className);
        }

        try {
            $instance = $this->container->get($className);
        } catch (ContainerExceptionInterface $ex) {
            throw new PohodaException('Parameter Entity cannot be initialized: ' . $className, 0, $ex);
        }

        if ($instance instanceof PrintRequest\Parameter) {
            return $instance;
        }

        throw new PohodaException('Entity is not an instance of PrintRequest\Parameter: ' . $className);
    }
}
