<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\AddressBook\Header;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class AddressBook extends AbstractAgenda
{
    use Common\AddActionTypeTrait;
    use Common\AddParameterToHeaderTrait;

    public function getImportRoot(): string
    {
        return 'lAdb:addressbook';
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
        if (!empty($data)) {
            $data = ['header' => new Header($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions)];
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('adb:addressbook', '', $this->namespace('adb'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['actionType', 'header'], 'adb');

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
