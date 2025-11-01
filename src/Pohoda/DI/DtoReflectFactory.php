<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

final class DtoReflectFactory implements DtoFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDto(string|object $name): AbstractDto
    {
        try {
            $reflection = new ReflectionClass($name);
            $class = $reflection->newInstance();
        } catch (ReflectionException $e) {
            throw new DomainException($e->getMessage(), $e->getCode(), $e);
        }
        if (!is_a($class, AbstractDto::class)) {
            throw new DomainException(sprintf('The class *%s* is not subclass of AbstractDto', get_class($class)));
        }
        return $class;
    }
}
