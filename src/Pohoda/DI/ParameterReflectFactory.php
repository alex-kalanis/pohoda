<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\PrintRequest;

final class ParameterReflectFactory implements ParameterFactoryInterface
{
    public function __construct(
        protected readonly DependenciesFactory $dependenciesFactory,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getByClassName(string $className): PrintRequest\Parameter
    {
        try {
            $reflection = new ReflectionClass($className);
            $class = $reflection->newInstance(
                $this->dependenciesFactory,
            );
        } catch (ReflectionException $e) {
            throw new DomainException($e->getMessage(), $e->getCode(), $e);
        }
        if (!is_a($class, PrintRequest\Parameter::class)) {
            throw new DomainException(sprintf('The class *%s* is not subclass of Parameter', get_class($class)));
        }
        return $class;
    }
}
