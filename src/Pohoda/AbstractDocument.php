<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\Common\AddParameterToHeaderTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


abstract class AbstractDocument extends AbstractAgenda
{
    use AddParameterToHeaderTrait;

    protected DocumentPartFactory $documentPartFactory;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
        OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new OptionsResolver\Normalizers\NormalizerFactory(),
    )
    {
        $this->documentPartFactory = new DocumentPartFactory($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $normalizerFactory);

        parent::__construct($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $resolveOptions, $normalizerFactory);
    }

    /**
     * Add document item.
     *
     * @param array<string,mixed> $data
     *
     * @return Document\AbstractPart
     */
    public function addItem(array $data): Document\AbstractPart
    {
        $key = $this->getDocumentName() . 'Detail';

        if (!isset($this->data[$key])
            || !(
                is_array($this->data[$key])
                || (is_object($this->data[$key]) && is_a($this->data[$key], \ArrayAccess::class))
            )
        ) {
            $this->data[$key] = [];
        }

        $part = $this->getDocumentPart('Item')->setData($data);
        $this->data[$key][] = $part;

        return $part;
    }

    /**
     * Add document summary.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addSummary(array $data): self
    {
        $this->data['summary'] = $this->getDocumentPart('Summary')->setData($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // pass to header
        if (!empty($data)) {
            $data = ['header' => $this->getDocumentPart('Header', $this->resolveOptions)->setData($data)];
        }
        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild($this->getDocumentNamespace() . ':' . $this->getDocumentName(), '', $this->namespace($this->getDocumentNamespace()));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, $this->getDocumentElements(), $this->getDocumentNamespace());

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }

    /**
     * Document part factory.
     * This code is the loader for things like "Header", "Summary", "Item"
     *
     * @param string              $partName
     * @param bool                $resolveOptions
     *
     * @return Document\AbstractPart
     */
    protected function getDocumentPart(string $partName, bool $resolveOptions = true): Document\AbstractPart
    {
        $part = $this->documentPartFactory->getPart(\get_class($this), $partName, $resolveOptions);
        $part->setNamespace($this->getDocumentNamespace());
        $part->setNodePrefix($this->getDocumentName());
        return $part;
    }

    /**
     * Get defined elements.
     *
     * @return string[]
     */
    protected function getDocumentElements(): array
    {
        return ['header', $this->getDocumentName() . 'Detail', 'summary'];
    }

    /**
     * Get document namespace.
     *
     * @return string
     */
    abstract protected function getDocumentNamespace(): string;

    /**
     * Get document name used in XML nodes.
     *
     * @return string
     */
    abstract protected function getDocumentName(): string;
}
