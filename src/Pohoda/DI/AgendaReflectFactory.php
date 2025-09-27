<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\ValueTransformer;

class AgendaReflectFactory implements AgendaFactoryInterface
{
    public function __construct(
        protected readonly DependenciesFactory $dependenciesFactory,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getAgenda(string $name): AbstractAgenda
    {
        /** @var class-string<AbstractAgenda> $className */
        $className = __NAMESPACE__ . '\\' . $name;
        try {
            $reflection = new ReflectionClass($className);
        } catch (ReflectionException) {
            throw new DomainException('Agenda class does not exists: ' . $name);
        }

        if (!$reflection->isInstantiable()) {
            throw new DomainException('Agenda class cannot be initialized: ' . $name);
        }

        try {
            $instance = $reflection->newInstance(
                $this->dependenciesFactory,
            );
            // @codeCoverageIgnoreStart
        } catch (ReflectionException) {
            throw new DomainException('Agenda class initialization failed: ' . $name);
        }
        // @codeCoverageIgnoreEnd

        if (!is_a($instance, AbstractAgenda::class)) {
            throw new DomainException('Agenda class is not an instance of AbstractAgenda: ' . $name);
        }

        return $instance;
    }
}
