<?php

declare(strict_types=1);

namespace kalanis\Pohoda\UserList;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property ItemUserCodeDto $data
 */
class ItemUserCode extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:itemUserCode', '', $this->namespace('lst'));
        $xml->addAttribute('code', strval($this->data->code));
        $xml->addAttribute('name', strval($this->data->name));

        if (isset($this->data->constant)) {
            $xml->addAttribute('constant', strval($this->data->constant));
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemUserCodeDto();
    }
}
