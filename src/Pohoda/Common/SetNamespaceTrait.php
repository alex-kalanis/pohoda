<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Common;

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
            throw new \LogicException('Namespace not set.');
        }

        if (is_null($this->nodeName)) {
            throw new \LogicException('Node name not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodeName, '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->elements, 'typ');

        return $xml;
    }
}
