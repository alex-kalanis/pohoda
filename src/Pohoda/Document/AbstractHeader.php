<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Document;


use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


abstract class AbstractHeader extends AbstractPart
{
    use Common\AddParameterTrait;

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
        // process partner identity
        if (isset($data['partnerIdentity'])) {
            $data['partnerIdentity'] = new Type\Address($namespacesPaths, $sanitizeEncoding, $data['partnerIdentity'], $companyRegistrationNumber, $resolveOptions);
        }

        // process my identity
        if (isset($data['myIdentity'])) {
            $data['myIdentity'] = new Type\MyAddress($namespacesPaths, $sanitizeEncoding, $data['myIdentity'], $companyRegistrationNumber, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new \LogicException('Namespace not set.');
        }

        if (is_null($this->nodePrefix)) {
            throw new \LogicException('Node name prefix not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Header', '', $this->namespace($this->namespace));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), $this->namespace);

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
