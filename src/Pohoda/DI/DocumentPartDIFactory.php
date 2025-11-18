<?php

namespace kalanis\Pohoda\DI;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use kalanis\Pohoda\Document;

final class DocumentPartDIFactory implements DocumentPartFactoryInterface
{
    public function __construct(
        protected readonly ContainerInterface $container,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getPart(string $parentClass, string $name): Document\AbstractPart
    {
        $className = $parentClass . '\\' . $name;
        if (!$this->container->has($className)) {
            throw new DomainException('Entity does not exists: ' . $name);
        }

        try {
            $instance = $this->container->get($className);
        } catch (ContainerExceptionInterface $ex) {
            throw new DomainException('Entity cannot be initialized: ' . $name, 0, $ex);
        }

        if ($instance instanceof Document\AbstractPart) {
            return $instance;
        }

        throw new DomainException('Entity is not an instance of AbstractPart: ' . $name);
    }
}
