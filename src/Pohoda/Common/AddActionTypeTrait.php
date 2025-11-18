<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\Pohoda\Type;

/**
 * @property object{
 *     actionType?: Type\ActionType,
 * } $data
 */
trait AddActionTypeTrait
{
    /**
     * Add action type.
     *
     * @param string      $type
     * @param array<string, string|int|float|bool|array<string, string|int|float|bool>>  $filter
     * @param string|null $agenda
     *
     * @return self
     */
    public function addActionType(string $type, array $filter = [], ?string $agenda = null): self
    {
        if (!empty($this->data->actionType)) {
            throw new \LogicException('Duplicate action type.');
        }

        $actionTypeDto = new Type\Dtos\ActionTypeDto();
        $actionTypeDto->type = $type;
        $actionTypeDto->filter = $filter;
        $actionTypeDto->agenda = $agenda;

        $actionType = new Type\ActionType(
            $this->dependenciesFactory,
        );
        $actionType
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($actionTypeDto);
        $this->data->actionType = $actionType;

        return $this;
    }
}
