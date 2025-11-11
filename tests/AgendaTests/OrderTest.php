<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class OrderTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Order::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:order', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader></ord:order>', $lib->getXML()->asXML());
    }

    public function testSetActionType(): void
    {
        $lib = $this->getLib();
        $lib->addActionType('update', [
            'numberOrder' => '222',
        ]);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:actionType><ord:update><ftr:filter><ftr:numberOrder>222</ftr:numberOrder></ftr:filter></ord:update></ord:actionType></ord:order>', $lib->getXML()->asXML());
    }

    public function testAddItems(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\Order\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->delivered = 0;
        $item1->rateVAT = 'high';
        $item1->homeCurrency = $home1;

        $lib = $this->getLib();
        $lib->addItem($item1);

        $home2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home2->unitPrice = 198;

        $stock = new Pohoda\Type\Dtos\StockItemDto();
        $stock->stockItem = [
            'ids' => 'STM',
        ];
        $stock->insertAttachStock = false;
        $stock->applyUserSettingsFilterOnTheStore = false;

        $item2 = new Pohoda\Order\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock;

        $lib->addItem($item2);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>NAME 1</ord:text><ord:quantity>1</ord:quantity><ord:delivered>0</ord:delivered><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>200</typ:unitPrice></ord:homeCurrency></ord:orderItem><ord:orderItem><ord:quantity>1</ord:quantity><ord:payVAT>true</ord:payVAT><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>198</typ:unitPrice></ord:homeCurrency><ord:stockItem><typ:stockItem insertAttachStock="false" applyUserSettingsFilterOnTheStore="false"><typ:ids>STM</typ:ids></typ:stockItem></ord:stockItem></ord:orderItem></ord:orderDetail></ord:order>', $lib->getXML()->asXML());
    }

    public function testAddItems2(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\Order\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->delivered = 0;
        $item1->rateVAT = 'high';
        $item1->homeCurrency = $home1;

        $lib = $this->getLib();
        $lib->setDirectionalVariable(true);
        $lib->addItem($item1);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>NAME 1</ord:text><ord:quantity>1</ord:quantity><ord:delivered>0</ord:delivered><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>200</typ:unitPrice></ord:homeCurrency></ord:orderItem></ord:orderDetail></ord:order>', $lib->getXML()->asXML());
    }

    public function testCustomHeader(): void
    {
        $header = new Pohoda\Order\HeaderDto();
        $header->numberOrder = '1234567890';
        $header->isDelivered = true;

        $dto = new Pohoda\Order\OrderDto();
        $dto->header = $header;

        $lib = new Pohoda\Order($this->getBasicDi());
        $lib->setDirectionalVariable(true);
        $lib->setData($dto);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader><ord:orderType>receivedOrder</ord:orderType><ord:numberOrder>1234567890</ord:numberOrder><ord:isDelivered>true</ord:isDelivered></ord:orderHeader></ord:order>', $lib->getXML()->asXML());
    }

    public function testHeaderKillNamespace(): void
    {
        $lib = new Pohoda\Order\Header($this->getBasicDi());
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testHeaderKillNodePrefix(): void
    {
        $lib = new Pohoda\Order\Header($this->getBasicDi());
        $lib->setNamespace('test');
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testItemKillNamespace(): void
    {
        $lib = new Pohoda\Order\Item($this->getBasicDi());
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testItemKillNodePrefix(): void
    {
        $lib = new Pohoda\Order\Item($this->getBasicDi());
        $lib->setNamespace('test');
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testSummaryKillNamespace(): void
    {
        $lib = new Pohoda\Order\Summary($this->getBasicDi());
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testSummaryKillNodePrefix(): void
    {
        $lib = new Pohoda\Order\Summary($this->getBasicDi());
        $lib->setNamespace('test');
        $this->expectException(\LogicException::class);
        $lib->getXML();
    }

    public function testSetSummary(): void
    {
        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\Order\SummaryDto();
        $summary->roundingDocument = 'math2one';
        $summary->foreignCurrency = $foreign;

        $lib = $this->getLib();
        $lib->addSummary($summary);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderSummary><ord:roundingDocument>math2one</ord:roundingDocument><ord:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></ord:foreignCurrency></ord:orderSummary></ord:order>', $lib->getXML()->asXML());
    }

    public function testSetSummary2(): void
    {
        $summary = new Pohoda\Order\SummaryDto();
        $summary->roundingDocument = 'math2one';

        $lib = $this->getLib();
        $lib->setDirectionalVariable(true);
        $lib->addSummary($summary);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderSummary><ord:roundingDocument>math2one</ord:roundingDocument></ord:orderSummary></ord:order>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '<ord:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></ord:parameters></ord:orderHeader></ord:order>', $lib->getXML()->asXML());
    }

    public function testDeleteOrder(): void
    {
        $lib = new Pohoda\Order($this->getBasicDi());
        $lib->addActionType('delete', [
            'number' => '222',
        ], 'prijate_objednavky');

        $this->assertEquals('<ord:order version="2.0"><ord:actionType><ord:delete><ftr:filter agenda="prijate_objednavky"><ftr:number>222</ftr:number></ftr:filter></ord:delete></ord:actionType></ord:order>', $lib->getXML()->asXML());
    }

    public function testWithSpecialCharsIntact(): void
    {
        $addrType = new Pohoda\Type\Dtos\AddressTypeDto();
        $addrType->name = 'Călărași ñüé¿s';
        $addrType->city = 'Dâmbovița';

        $addr = new Pohoda\Type\Dtos\AddressDto();
        $addr->address = $addrType;

        $header = new Pohoda\AddressBook\HeaderDto();
        $header->phone = '123';
        $header->centre = ['id' => 1];
        $header->identity = $addr;

        $dto = new Pohoda\AddressBook\AddressBookDto();
        $dto->header = $header;

        $lib = new Pohoda\AddressBook($this->getBasicDi());
        $lib->setData($dto);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:addressbookHeader><adb:identity><typ:address><typ:name>Călărași ñüé¿s</typ:name><typ:city>Dâmbovița</typ:city></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre></adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<ord:orderType>receivedOrder</ord:orderType><ord:date>2015-01-10</ord:date><ord:partnerIdentity><typ:id>25</typ:id></ord:partnerIdentity><ord:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></ord:myIdentity><ord:intNote>Note</ord:intNote>';
    }

    protected function getLib(): Pohoda\Order
    {
        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 25;

        $mineAddr = new Pohoda\Type\Dtos\AddressInternetTypeDto();
        $mineAddr->name = 'NAME';
        $mineAddr->ico = '123';

        $mine = new Pohoda\Type\Dtos\MyAddressDto();
        $mine->address = $mineAddr;

        $header = new Pohoda\Order\HeaderDto();
        $header->date = '2015-01-10';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;
        $header->myIdentity = $mine;

        $dto = new Pohoda\Order\OrderDto();
        $dto->header = $header;

        $lib = new Pohoda\Order($this->getBasicDi());
        return $lib->setData($dto);
    }
}
