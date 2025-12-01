<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Common;

use kalanis\PohodaException;

trait SetNamespaceTrait
{
    protected ?string $namespace = null;

    protected ?string $nodeName = null;

    /**
     * Set namespace.
     *
     * @param string $namespace
     *
     * @return void
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * Set node name.
     *
     * @param string $nodeName
     *
     * @return void
     */
    public function setNodeName(string $nodeName): void
    {
        $this->nodeName = $nodeName;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new PohodaException('Namespace not set.');
        }

        if (is_null($this->nodeName)) {
            throw new PohodaException('Node name not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodeName, '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->getDataElements(), 'typ');

        return $xml;
    }

    /**
     * Get namespace.
     *
     * @param string $short
     *
     * @return string
     */
    abstract protected function namespace(string $short): string;

    /**
     * Create XML.
     *
     * @return \SimpleXMLElement
     */
    abstract protected function createXML(): \SimpleXMLElement;

    /**
     * Add batch elements.
     *
     * @param \SimpleXMLElement $xml
     * @param string[]          $elements
     * @param string|null       $namespace
     *
     * @return void
     */
    abstract protected function addElements(\SimpleXMLElement $xml, array $elements, ?string $namespace = null): void;

    /**
     * Add elements defined as properties of DTOs
     *
     * @return string[]
     */
    abstract protected function getDataElements(bool $withAttributes = false): array;
}
