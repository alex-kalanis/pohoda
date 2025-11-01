<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Riesenia\Pohoda\AbstractAgenda;

final class AgendaDIFactory implements AgendaFactoryInterface
{
    use ClassNameTrait;

    public function __construct(
        protected readonly ContainerInterface $container,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getAgenda(string $name): AbstractAgenda
    {
        $className = $this->getClassName($name);
        if (!$this->container->has($className)) {
            throw new DomainException('Agenda class does not exists: ' . $name);
        }

        try {
            $instance = $this->container->get($className);
        } catch (ContainerExceptionInterface $ex) {
            throw new DomainException('Agenda class initialization failed: ' . $name, 0, $ex);
        }

        if ($instance instanceof AbstractAgenda) {
            return $instance;
        }

        throw new DomainException('Agenda class is not an instance of AbstractAgenda: ' . $name);
    }
}
