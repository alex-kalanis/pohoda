<?php

declare(strict_types=1);

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class Pdf extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:pdf', '', $this->namespace('prn'));

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new PdfDto();
    }
}
