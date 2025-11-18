<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property PictureDto $data
 */
class Picture extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:picture', '', $this->namespace('stk'));
        $xml->addAttribute('default', \strval($this->data->default));

        $this->addElements($xml, $this->getDataElements(), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new PictureDto();
    }
}
