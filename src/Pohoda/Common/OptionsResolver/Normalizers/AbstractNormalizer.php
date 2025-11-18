<?php

namespace kalanis\Pohoda\Common\OptionsResolver\Normalizers;

use kalanis\Pohoda\Common\Dtos\AbstractDto;

/**
 * Normalization of content
 */
abstract class AbstractNormalizer
{
    protected int|null $length = null;
    protected bool $nullable = false;
    protected mixed $custom = null;
    protected ?AbstractDto $dto = null;

    public function setParams(
        int|null $length = null,
        bool $nullable = false,
        mixed $custom = null,
        ?AbstractDto $dto = null,
    ): self {
        $this->length = $length;
        $this->nullable = $nullable;
        $this->custom = $custom;
        $this->dto = $dto;
        return $this;
    }

    /**
     * Normalize that content
     * @param mixed $options
     * @param mixed $value
     * @return mixed
     */
    abstract public function normalize(mixed $options, mixed $value): mixed;
}
