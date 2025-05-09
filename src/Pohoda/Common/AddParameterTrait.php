<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;


use Riesenia\Pohoda\Type\Parameter;


/**
 * @property array<string, mixed> $data
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
        if (!isset($this->data['parameters'])
            || !(
                is_array($this->data['parameters'])
                || (is_object($this->data['parameters']) && is_a($this->data['parameters'], \ArrayAccess::class))
            )
        ) {
            $this->data['parameters'] = [];
        }

        $this->data['parameters'][] = new Parameter($this->namespacesPaths, $this->sanitizeEncoding, [
            'name' => $name,
            'type' => $type,
            'value' => $value,
            'list' => $list
        ], $this->companyRegistrationNumber);

        return $this;
    }
}
