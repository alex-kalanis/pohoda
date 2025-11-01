<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class StockTransferTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\StockTransfer::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:prevodka', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '</pre:prevodkaHeader></pre:prevodka>', $this->getLib()->getXML()->asXML());
    }

    public function testAddItems(): void
    {
        $stock1 = new Pohoda\Type\Dtos\StockItemDto();
        $stock1->stockItem = [
            'ids' => 'model',
            'store' => 'X',
        ];
        $item1 = new Pohoda\StockTransfer\ItemDto();
        $item1->quantity = 2;
        $item1->stockItem = $stock1;

        $lib = $this->getLib();
        $lib->addItem($item1);

        $stock2 = new Pohoda\Type\Dtos\StockItemDto();
        $stock2->stockItem = [
            'ids' => 'STM',
        ];
        $item2 = new Pohoda\StockTransfer\ItemDto();
        $item2->quantity = 1;
        $item2->note = 'STM';
        $item2->stockItem = $stock2;

        $lib->addItem($item2);

        $this->assertEquals('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '</pre:prevodkaHeader><pre:prevodkaDetail><pre:prevodkaItem><pre:quantity>2</pre:quantity><pre:stockItem><typ:stockItem><typ:ids>model</typ:ids><typ:store>X</typ:store></typ:stockItem></pre:stockItem></pre:prevodkaItem><pre:prevodkaItem><pre:quantity>1</pre:quantity><pre:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pre:stockItem><pre:note>STM</pre:note></pre:prevodkaItem></pre:prevodkaDetail></pre:prevodka>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '<pre:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pre:parameters></pre:prevodkaHeader></pre:prevodka>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<pre:date>2015-01-10</pre:date><pre:store><typ:ids>MAIN</typ:ids></pre:store><pre:text>Prevodka na MAIN</pre:text><pre:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></pre:partnerIdentity><pre:activity><typ:id>1</typ:id></pre:activity><pre:intNote>Note</pre:intNote>';
    }

    protected function getLib(): Pohoda\StockTransfer
    {
        $partnerAddress = new Pohoda\Type\Dtos\AddressTypeDto();
        $partnerAddress->name = 'NAME';
        $partnerAddress->ico = '123';

        $partnerIdentity = new Pohoda\Type\Dtos\AddressDto();
        $partnerIdentity->address = $partnerAddress;

        $stockHeader = new Pohoda\StockTransfer\HeaderDto();
        $stockHeader->date = '2015-01-10';
        $stockHeader->store = [
            'ids' => 'MAIN',
        ];
        $stockHeader->text = 'Prevodka na MAIN';
        $stockHeader->activity = [
            'id' => 1,
        ];
        $stockHeader->intNote = 'Note';
        $stockHeader->partnerIdentity = $partnerIdentity;

        $lib = new Pohoda\StockTransfer($this->getBasicDi());
        return $lib->setData($stockHeader);
    }
}
