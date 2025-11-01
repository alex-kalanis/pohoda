<?php

namespace DiTests;

use Riesenia\Pohoda;
use tests\CommonTestClass;
use tests\DiTests\XClassName;

class ClassNameTest extends CommonTestClass
{
    public function testShortStringName(): void
    {
        $this->assertEquals(Pohoda\XAgenda::class, $this->getLib()->getClassName('XAgenda'));
    }

    public function testFullStringName(): void
    {
        $this->assertEquals(Pohoda\XAgenda::class, $this->getLib()->getClassName(Pohoda\XAgenda::class));
    }

    public function testClassNameWithAbsolutePath(): void
    {
        $this->assertEquals('Different\Path', $this->getLib()->getClassName('\Different\Path'));
    }

    public function testClassNameWithRelativePath(): void
    {
        $this->assertEquals('Riesenia\Pohoda\Different\Path', $this->getLib()->getClassName('Different\Path'));
    }

    protected function getLib(): XClassName
    {
        return new XClassName();
    }
}
