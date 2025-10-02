<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\Document;

class DocumentPartReflectFactory implements DocumentPartFactoryInterface
{
    public function __construct(
        protected readonly DependenciesFactory $dependenciesFactory,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getPart(string $parentClass, string $name): Document\AbstractPart
    {
        /** @var class-string<Document\AbstractPart> $className */
        $className = $parentClass . '\\' . $name;
        try {
            $reflection = new ReflectionClass($className);
        } catch (ReflectionException) {
            throw new DomainException('Entity does not exists: ' . $name);
        }

        if (!$reflection->isInstantiable()) {
            throw new DomainException('Entity cannot be initialized: ' . $name);
        }

        try {
            $instance = $reflection->newInstance(
                $this->dependenciesFactory,
            );
            // @codeCoverageIgnoreStart
        } catch (ReflectionException) {
            throw new DomainException('Entity initialization failed: ' . $name);
        }
        // @codeCoverageIgnoreEnd

        if (!is_a($instance, Document\AbstractPart::class)) {
            throw new DomainException('Entity is not an instance of AbstractPart: ' . $name);
        }

        return $instance;
    }
}
