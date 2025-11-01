<?php

namespace tests\DiTests;

use Psr\Container\ContainerInterface;

/**
 * Really simplified version of container DI
 * Just for testing purposes
 */
class TestingContainer implements ContainerInterface
{
    /** @var array<class-string, object> */
    protected readonly array $objects;

    protected bool $killGet = false;

    /**
     * @param object[] $objects
     */
    public function __construct(
        array $objects,
    ) {
        $obj = [];
        foreach ($objects as $object) {
            $obj[get_class($object)] = $object;
        }
        $this->objects = $obj;
    }

    public function setKillGet(bool $value): self
    {
        $this->killGet = $value;
        return $this;
    }

    public function get(string $id)
    {
        if ($this->killGet) {
            throw new ContainerException('mock');
        }
        return $this->has($id) ? $this->objects[$id] : throw new NotFoundException('mock');
    }

    public function has(string $id): bool
    {
        return isset($this->objects[$id]);
    }
}
