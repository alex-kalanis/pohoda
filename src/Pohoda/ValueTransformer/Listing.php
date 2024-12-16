<?php

namespace Riesenia\Pohoda\ValueTransformer;


class Listing
{
    /**
     * A set of transformers that will be used when serializing data.
     *
     * @var ValueTransformer[]
     */
    protected array $list = [];

    /**
     * @return ValueTransformer[]
     */
    public function getTransformers(): array
    {
        return $this->list;
    }

    public function addTransformer(ValueTransformer $transformer): self
    {
        $this->list[] = $transformer;
        return $this;
    }

    public function clear(): self
    {
        $this->list = [];
        return $this;
    }
}
