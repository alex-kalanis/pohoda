<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

class PrintRequest extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        if (!empty($data->record)) {
            // process record
            $record = new PrintRequest\Record($this->dependenciesFactory);
            $record
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->record);
            $data->record = $record;
        }

        if (!empty($data->printerSettings)) {
            // process printer settings
            $printerSettings = new PrintRequest\PrinterSettings($this->dependenciesFactory);
            $printerSettings
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->printerSettings);
            $data->printerSettings = $printerSettings;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:print', '', $this->namespace('prn'));
        $xml->addAttribute('version', '1.0');

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new PrintRequest\PrintRequestDto();
    }
}
