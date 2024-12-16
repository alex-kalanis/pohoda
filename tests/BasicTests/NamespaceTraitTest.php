<?php

namespace BasicTests;


use CommonTestClass;
use LogicException;
use OutOfRangeException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Common\SetNamespaceTrait;


class NamespaceTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new XNamespace();
        $lib->setNamespace('foo');
        $lib->setNodeName('bar');
        $this->assertEquals('<foo:bar xmlns:foo="foo"/>', $lib->getXML()->asXML());
    }

    public function testNoNamespace(): void
    {
        $lib = new XNamespace();
        $lib->setNodeName('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoNodeName(): void
    {
        $lib = new XNamespace();
        $lib->setNamespace('foo');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNonExistentName(): void
    {
        $lib = new NamespacesPaths();
        $this->expectException(OutOfRangeException::class);
        $lib->namespace('this does not exists');
    }
}


class XNamespace
{
    use SetNamespaceTrait;

    protected array $elements = [];

    protected function createXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('<?xml version="1.0" ?><root></root>');
    }

    protected function namespace(string $short): string
    {
        return $short;
    }

    protected function addElements(\SimpleXMLElement $xml, array $elements, ?string $namespace = null): void
    {}
}
