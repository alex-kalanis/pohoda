<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

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
        $subStore = new Pohoda\Storage\StorageDto();
        $subStore->code = 'Sub';
        $subStore->name = 'Sub';

        $lib = $this->getLib();
        $sub = new Pohoda\Storage($this->getBasicDi());
        $sub->setData($subStore);

        $lib->addSubStorage($sub);

        $this->assertEquals('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"/></str:subStorages></str:itemStorage></str:storage>', $lib->getXML()->asXML());

        $subSubStore = new Pohoda\Storage\StorageDto();
        $subSubStore->code = 'SubSub';
        $subSubStore->name = 'SubSub';

        $subSub = new Pohoda\Storage($this->getBasicDi());
        $subSub->setData($subSubStore);

        $sub->addSubStorage($subSub);

        $this->assertEquals('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"><str:subStorages><str:itemStorage code="SubSub" name="SubSub"/></str:subStorages></str:itemStorage></str:subStorages></str:itemStorage></str:storage>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\Storage
    {
        $store = new Pohoda\Storage\StorageDto();
        $store->code = 'MAIN';

        $lib = new Pohoda\Storage($this->getBasicDi());
        return $lib->setData($store);
    }
}
