<?php

namespace tests\BasicTests;

use kalanis\PohodaException;
use tests\CommonTestClass;
use OutOfRangeException;
use kalanis\Pohoda\Common\NamespacesPaths;

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
        $this->expectException(PohodaException::class);
        $lib->getXML();
    }

    public function testNoNodeName(): void
    {
        $lib = new XNamespace();
        $lib->setNamespace('foo');
        $this->expectException(PohodaException::class);
        $lib->getXML();
    }

    public function testNonExistentName(): void
    {
        $lib = new NamespacesPaths();
        $this->expectException(PohodaException::class);
        $lib->namespace('this does not exists');
    }
}
