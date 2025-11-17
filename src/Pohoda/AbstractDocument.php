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
 * @property Document\AbstractDocumentDto $data
 */
abstract class AbstractDocument extends AbstractAgenda
{
    use Common\AddParameterToHeaderTrait;

    /**
     * Add document item.
     *
     * @param Common\Dtos\AbstractItemDto $data
     *
     * @return Document\AbstractPart
     */
    public function addItem(Common\Dtos\AbstractItemDto $data): Document\AbstractPart
    {
        $part = $this->getDocumentPart('Item');
        $part->setDirectionalVariable($this->useOneDirectionalVariables);
        $part->setData($data);
        if (is_a($part, Document\AbstractItem::class)) {
            $this->data->details[] = $part;
        }

        return $part;
    }

    /**
     * Add document summary.
     *
     * @param Common\Dtos\AbstractSummaryDto $data
     *
     * @return $this
     */
    public function addSummary(Common\Dtos\AbstractSummaryDto $data): self
    {
        $summary = $this->getDocumentPart('Summary');
        $summary->setDirectionalVariable($this->useOneDirectionalVariables);
        $summary->setData($data);
        if (is_a($summary, Document\AbstractSummary::class)) {
            $this->data->summary = $summary;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
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

        $this->addElements(
            $xml,
            $this->getDataElements(),
            $this->getDocumentNamespace(),
        );

        return $xml;
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
