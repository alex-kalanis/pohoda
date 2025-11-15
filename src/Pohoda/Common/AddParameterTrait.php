<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

/**
 * @property Common\Dtos\AbstractDto $data
 */
trait AddParameterTrait
{
    /**
     * Set user-defined parameter.
     *
     * @param string     $name  (can be set without preceding VPr / RefVPr)
     * @param string     $type
     * @param mixed      $value
     * @param mixed|null $list
     * @return self
     */
    public function addParameter(string $name, string $type, mixed $value, mixed $list = null): self
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
