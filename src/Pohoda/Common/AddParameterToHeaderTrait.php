<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\Pohoda\AbstractAgenda;

/**
 * @property Dtos\AbstractDto $data
 */
trait AddParameterToHeaderTrait
{
    /**
     * Set user-defined parameter.
     *
     * @param string     $name  (can be set without preceding VPr / RefVPr)
     * @param string     $type
     * @param mixed      $value
     * @param mixed|null $list
     *
     * @return AbstractAgenda
     */
    public function addParameter(string $name, string $type, mixed $value, mixed $list = null): AbstractAgenda
    {
        $object = $this->data->header ?? null;
        if ($object && is_object($object) && method_exists($object, 'addParameter')) {
            $object->addParameter($name, $type, $value, $list);
        }
        return $this;
    }
}
