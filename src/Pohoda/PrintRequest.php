<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property array{
 *     record: PrintRequest\Record,
 *     printerSettings: PrintRequest\PrinterSettings,
 * } $data
 */
class PrintRequest extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process record
        $record = new PrintRequest\Record($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $record->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['record']);
        $data['record'] = $record;

        // process printer settings
        $printerSettings = new PrintRequest\PrinterSettings($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $printerSettings->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['printerSettings']);
        $data['printerSettings'] = $printerSettings;

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
