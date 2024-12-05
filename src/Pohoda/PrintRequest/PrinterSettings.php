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
use Riesenia\Pohoda\Common\OptionsResolver;

class PrinterSettings extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['report', 'printer', 'pdf', 'parameters'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process report
        if (isset($data['report'])) {
            $data['report'] = new Report($data['report'], $ico, $resolveOptions);
        }
        // process pdf
        if (isset($data['pdf'])) {
            $data['pdf'] = new Pdf($data['pdf'], $ico, $resolveOptions);
        }
        // process parameters
        if (isset($data['parameters'])) {
            $data['parameters'] = new Parameters($data['parameters'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
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
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
