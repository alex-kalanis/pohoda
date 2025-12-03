<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\Pohoda\Type;

/**
 * @property object{
 *     parameters: array<Type\Parameter>
 * } $data
 */
trait AddParameterTrait
{
    /**
     * Set user-defined parameter.
     *
     * @param string     $name  (can be set without preceding VPr / RefVPr)
     * @param Type\Enums\ParameterTypeEnum|string $type
     * @param mixed      $value
     * @param mixed|null $list
     * @return self
     */
    public function addParameter(string $name, Type\Enums\ParameterTypeEnum|string $type, mixed $value, mixed $list = null): self
    {
        $parameter = new Type\Parameter(
            $this->dependenciesFactory,
        );
        $dto = new Type\Dtos\ParameterDto();
        $dto->name = $name;
        $dto->type = $type;
        $dto->value = $value;
        $dto->list = $list;

        $parameter
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($dto);
        $this->data->parameters[] = $parameter;

        return $this;
    }
}
