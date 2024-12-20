<?php

namespace AgendaTests;


use CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;


class StorageTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Storage::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:itemStorage', $lib->getImportRoot());
    }

    public function testCreateCorrectXmlPdf(): void
    {
        $this->assertEquals('<str:storage version="2.0"><str:itemStorage code="MAIN"/></str:storage>', $this->getLib()->getXML()->asXML());
    }

    public function testAddSubStorages(): void
    {
        $lib = $this->getLib();
        $sub = new Pohoda\Storage(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'code' => 'Sub',
            'name' => 'Sub'
        ], '123');

        $lib->addSubstorage($sub);

        $this->assertEquals('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"/></str:subStorages></str:itemStorage></str:storage>', $lib->getXML()->asXML());

        $subsub = new Pohoda\Storage(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'code' => 'SubSub',
            'name' => 'SubSub'
        ], '123');

        $sub->addSubstorage($subsub);

        $this->assertEquals('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"><str:subStorages><str:itemStorage code="SubSub" name="SubSub"/></str:subStorages></str:itemStorage></str:subStorages></str:itemStorage></str:storage>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\Storage
    {
        return new Pohoda\Storage(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'code' => 'MAIN'
        ], '123');
    }
}
