<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property Dtos\ParameterDto $data
 */
class Parameter extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:parameter', '', $this->namespace('typ'));

        $child = $this->data->name ?? null;
        $xml->addChild('typ:name', is_null($child) ? null : \strval($child));

        if ('list' == $this->data->type) {
            $this->addRefElement($xml, 'typ:listValueRef', $this->data->value);

            if (!empty($this->data->list)) {
                $this->addRefElement($xml, 'typ:list', $this->data->list);
            }

        } elseif ('boolean' == $this->data->type) {
            $xml->addChild('typ:' . $this->data->type . 'Value', $this->data->value ? 'true' : 'false');

        } else {
            $xml->addChild('typ:' . $this->data->type . 'Value', \htmlspecialchars(\strval($this->data->value)));
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\ParameterDto();
    }
}
