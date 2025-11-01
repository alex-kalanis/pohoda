<?php

namespace Riesenia\Pohoda\ValueTransformer;

final class Listing
{
    /**
     * A set of transformers that will be used when serializing data.
     *
     * @var ValueTransformerInterface[]
     */
    protected array $list = [];

    /**
     * @return ValueTransformerInterface[]
     */
    public function getTransformers(): array
    {
        return $this->list;
    }

    public function addTransformer(ValueTransformerInterface $transformer): self
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
