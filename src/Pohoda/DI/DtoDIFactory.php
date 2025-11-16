<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

final class DtoDIFactory implements DtoFactoryInterface
{
    use ClassNameTrait;

    public function __construct(
        protected readonly ContainerInterface $container,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getDto(string|AbstractDto $name): AbstractDto
    {
        $className = is_object($name) ? get_class($name) : $name;
        if (!$this->container->has($className)) {
            throw new DomainException('Dto class does not exists: ' . $className);
        }

        try {
            $instance = $this->container->get($className);
        } catch (ContainerExceptionInterface $ex) {
            throw new DomainException('Dto class initialization failed: ' . $className, 0, $ex);
        }

        if ($instance instanceof AbstractDto) {
            return $instance;
        }

        throw new DomainException('Dto class is not an instance of AbstractDto: ' . $className);
    }
}
