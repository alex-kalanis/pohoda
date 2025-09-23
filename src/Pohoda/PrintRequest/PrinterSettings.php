<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class PrinterSettings extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['report', 'printer', 'pdf', 'parameters'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process report
        if (isset($data['report'])) {
            $report = new Report($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
            $data['report'] = $report->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['report']);
        }
        // process pdf
        if (isset($data['pdf'])) {
            $pdf = new Pdf($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
            $data['pdf'] = $pdf->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['pdf']);
        }
        // process parameters
        if (isset($data['parameters'])) {
            $parameters = new Parameters($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
            $data['parameters'] = $parameters->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['parameters']);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:printerSettings', '', $this->namespace('prn'));

        $this->addElements($xml, $this->elements, 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
