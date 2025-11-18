<?php

declare(strict_types=1);

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class PrinterSettings extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process report
        if (isset($data->report)) {
            $report = new Report($this->dependenciesFactory);
            $data->report = $report
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->report);
        }
        // process pdf
        if (isset($data->pdf)) {
            $pdf = new Pdf($this->dependenciesFactory);
            $data->pdf = $pdf
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->pdf);
        }
        // process parameters
        if (isset($data->parameters)) {
            $parameters = new Parameters($this->dependenciesFactory);
            $data->parameters = $parameters
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->parameters);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:printerSettings', '', $this->namespace('prn'));

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new PrinterSettingsDto();
    }
}
