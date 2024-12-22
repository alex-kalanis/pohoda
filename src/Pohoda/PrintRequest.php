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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class PrintRequest extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
    )
    {
        // process record
        $data['record'] = new Record($namespacesPaths, $sanitizeEncoding, $data['record'], $companyRegistrationNumber, $resolveOptions);

        // process printer settings
        $data['printerSettings'] = new PrinterSettings($namespacesPaths, $sanitizeEncoding, $data['printerSettings'], $companyRegistrationNumber, $resolveOptions);

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
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
