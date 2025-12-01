<?php

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\PohodaException;
use ReflectionClass;
use ReflectionException;

final class AgendaReflectFactory implements AgendaFactoryInterface
{
    use ClassNameTrait;

    public function __construct(
        protected readonly DependenciesFactory $dependenciesFactory,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getAgenda(string $name): AbstractAgenda
    {
        /** @var class-string<AbstractAgenda> $className */
        $className = $this->getClassName($name);
        try {
            $reflection = new ReflectionClass($className);
        } catch (ReflectionException) {
            throw new PohodaException('Agenda class does not exists: ' . $name);
        }

        if (!$reflection->isInstantiable()) {
            throw new PohodaException('Agenda class cannot be initialized: ' . $name);
        }

        try {
            $instance = $reflection->newInstance(
                $this->dependenciesFactory,
            );
            // @codeCoverageIgnoreStart
        } catch (ReflectionException) {
            throw new PohodaException('Agenda class initialization failed: ' . $name);
        }
        // @codeCoverageIgnoreEnd

        if (!is_a($instance, AbstractAgenda::class)) {
            throw new PohodaException('Agenda class is not an instance of AbstractAgenda: ' . $name);
        }

        return $instance;
    }
}
