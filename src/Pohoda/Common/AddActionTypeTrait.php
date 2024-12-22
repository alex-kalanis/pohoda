<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;


use Riesenia\Pohoda\Type\ActionType;


/**
 * @property array<string, mixed> $data
 */
trait AddActionTypeTrait
{
    /**
     * Add action type.
     *
     * @param string      $type
     * @param mixed|null  $filter
     * @param string|null $agenda
     *
     * @return self
     */
    public function addActionType(string $type, mixed $filter = null, ?string $agenda = null): self
    {
        if (isset($this->data['actionType'])) {
            throw new \OutOfRangeException('Duplicate action type.');
        }

        $this->data['actionType'] = new ActionType(
            $this->namespacesPaths,
            $this->sanitizeEncoding,
            [
                'type' => $type,
                'filter' => $filter,
                'agenda' => $agenda
            ],
            $this->companyRegistrationNumber,
        );

        return $this;
    }
}
