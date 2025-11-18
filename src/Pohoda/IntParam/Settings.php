<?php

declare(strict_types=1);

namespace kalanis\Pohoda\IntParam;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

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
