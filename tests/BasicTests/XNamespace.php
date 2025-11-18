<?php

namespace tests\BasicTests;

use kalanis\Pohoda\Common\SetNamespaceTrait;

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

    protected function addElements(\SimpleXMLElement $xml, array $elements, ?string $namespace = null): void {}

    protected function getDataElements(bool $withAttributes = false): array
    {
        return [];
    }
}
