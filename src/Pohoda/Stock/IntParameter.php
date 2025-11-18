<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property IntParameterDto $data
 */
class IntParameter extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:intParameter', '', $this->namespace('stk'));

        $this->addElements($xml, ['intParameterID', 'intParameterType'], 'stk');

        // value
        $value = $this->data->value ?? null;
        $xml->addChild('stk:intParameterValues')
            ->addChild('stk:intParameterValue')
            ->addChild(
                'stk:parameterValue',
                is_null($value) ? null : strval($value),
            );

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new IntParameterDto();
    }
}
