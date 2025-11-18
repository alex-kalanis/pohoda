<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\Pohoda\AbstractAgenda;

/**
 * @property object{
 *     header: AbstractAgenda
 * } $data
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
        $object = $this->data->header;
        /** @var self $object */
        $object->addParameter($name, $type, $value, $list);
        return $this;
    }
}
