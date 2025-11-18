<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Bank;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class StatementNumber extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('bnk:statementNumber', '', $this->namespace('bnk'));

        $this->addElements($xml, $this->getDataElements(), 'bnk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new StatementNumberDto();
    }
}
