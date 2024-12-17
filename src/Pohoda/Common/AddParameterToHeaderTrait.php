<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;


use Riesenia\Pohoda\AbstractAgenda;


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
        $object = $this->data['header'];
        /** @var self $object */
        $object->addParameter($name, $type, $value, $list);
        return $this;
    }
}
