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
use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Common\OptionsResolver;

abstract class AbstractDocument extends AbstractAgenda
{
    use AddParameterToHeaderTrait;

    /**
     * Add document item.
     *
     * @param Dtos\AbstractItemDto|null $data
     *
     * @return Document\AbstractPart
     */
    public function addItem(?Dtos\AbstractItemDto $data): Document\AbstractPart
    {
        $part = $this->getDocumentPart('Item')
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setData($data);
        $this->data->details[] = $part;

        return $part;
    }

    /**
     * Add document summary.
     *
     * @param Dtos\AbstractSummaryDto|null $data
     *
     * @return $this
     */
    public function addSummary(?Dtos\AbstractSummaryDto $data): self
    {
        $this->data->summary = $this->getDocumentPart('Summary')
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setData($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setData(?Dtos\AbstractDto $data): parent
    {
        // pass to header
        if (!empty($data->header)) {
            $data->header = $this->getDocumentPart('Header', $this->resolveOptions)
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setData($data->header);
        }
        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild(
            $this->getChildKey($this->getDocumentNamespace() . ':' . $this->getDocumentName()),
            '',
            $this->namespace($this->getChildNamespacePrefix($this->getDocumentNamespace())),
        );
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, $this->getDataElements(), $this->getDocumentNamespace());

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
        $part = $this->dependenciesFactory->getDocumentPartFactory()->getPart(\get_class($this), $partName);
        $part->setNamespace($this->getDocumentNamespace());
        $part->setNodePrefix($this->getDocumentName());
        $part->setResolveOptions($resolveOptions);
        return $part;
    }

    /**
     * Get defined elements.
     *
     * @return string[]
     */
    protected function getDocumentElements(): array
    {
        return ['header', 'details', 'summary'];
    }

    /**
     * @{inheritDoc}
     */
    protected function getNodeKey(string $key): string
    {
        if ('details' == $key) {
            return $this->getDocumentName() . 'Detail';
        }
        return $key;
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
