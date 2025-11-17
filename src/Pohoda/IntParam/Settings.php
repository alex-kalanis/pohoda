<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IntParam;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

class Settings extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ipm:parameterSettings', '', $this->namespace('ipm'));

        $this->addElements($xml, $this->getDataElements(), 'ipm');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new SettingsDto();
    }
}
