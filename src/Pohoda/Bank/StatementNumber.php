<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

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
