<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\Contract\Desc;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Contract extends AbstractAgenda
{
    use Common\AddParameterToHeaderTrait;


    public function getImportRoot(): string
    {
        return 'lCon:contract';
    }

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
        // pass to header
        $data = ['header' => new Desc($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions)];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contract', '', $this->namespace('con'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['header'], 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }
}
