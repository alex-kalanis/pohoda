<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\PrintRequest\PrinterSettings;
use Riesenia\Pohoda\PrintRequest\Record;


class PrintRequest extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process record
        $record = new Record($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $data['record'] = $record->setData($data['record']);

        // process printer settings
        $printerSettings = new PrinterSettings($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $data['printerSettings'] = $printerSettings->setData($data['printerSettings']);

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:print', '', $this->namespace('prn'));
        $xml->addAttribute('version', '1.0');

        $this->addElements($xml, ['record', 'printerSettings'], 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['record', 'printerSettings']);

        $resolver->setRequired('record');
        $resolver->setRequired('printerSettings');
    }
}
