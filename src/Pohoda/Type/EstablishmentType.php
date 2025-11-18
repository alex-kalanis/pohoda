<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class EstablishmentType extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:establishment', '', $this->namespace('typ'));

        $this->addElements($xml, $this->getDataElements(), 'typ');

        return $xml;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\EstablishmentTypeDto();
    }
}
