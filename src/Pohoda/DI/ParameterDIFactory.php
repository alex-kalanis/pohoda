<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Riesenia\Pohoda\PrintRequest;

class ParameterDIFactory implements ParameterFactoryInterface
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
            throw new DomainException('Parameter Entity does not exists: ' . $className);
        }

        try {
            $instance = $this->container->get($className);
        } catch (ContainerExceptionInterface $ex) {
            throw new DomainException('Parameter Entity cannot be initialized: ' . $className, 0, $ex);
        }

        if ($instance instanceof PrintRequest\Parameter) {
            return $instance;
        }

        throw new DomainException('Entity is not an instance of PrintRequest\Parameter: ' . $className);
    }
}
