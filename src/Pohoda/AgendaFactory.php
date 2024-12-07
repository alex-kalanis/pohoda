<?php

namespace Riesenia\Pohoda;


use DomainException;
use ReflectionClass;
use ReflectionException;


class AgendaFactory
{
    public function __construct(
        protected readonly string $companyNumber
    )
    {
    }

    /**
     * @param string $name
     * @param array<string,mixed> $data
     * @param bool $resolveOptions
     * @throws DomainException
     * @return AbstractAgenda
     */
    public function getAgenda(string $name, array $data, bool $resolveOptions = true): AbstractAgenda
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
            $instance = $reflection->newInstance($data, $this->companyNumber, $resolveOptions);
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
