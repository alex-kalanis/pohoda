<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

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
        $lib = $this->getLib();
        $lib->addItem([
            'text' => 'NAME 1',
            'quantity' => 1,
            'delivered' => 0,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 200,
            ],
        ]);

        $lib->addItem([
            'quantity' => 1,
            'payVAT' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 198,
            ],
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'STM',
                ],
                'insertAttachStock' => 0,
                'applyUserSettingsFilterOnTheStore' => false,
            ],
        ]);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>NAME 1</ord:text><ord:quantity>1</ord:quantity><ord:delivered>0</ord:delivered><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>200</typ:unitPrice></ord:homeCurrency></ord:orderItem><ord:orderItem><ord:quantity>1</ord:quantity><ord:payVAT>true</ord:payVAT><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>198</typ:unitPrice></ord:homeCurrency><ord:stockItem><typ:stockItem insertAttachStock="false" applyUserSettingsFilterOnTheStore="false"><typ:ids>STM</typ:ids></typ:stockItem></ord:stockItem></ord:orderItem></ord:orderDetail></ord:order>', $lib->getXML()->asXML());
    }

    public function testAddItems2(): void
    {
        $lib = $this->getLib();
        $lib->setDirectionalVariable(true);
        $lib->addItem([
            'text' => 'NAME 1',
            'quantity' => 1,
            'delivered' => 0,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 200,
            ],
        ]);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>NAME 1</ord:text><ord:quantity>1</ord:quantity><ord:delivered>0</ord:delivered><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>200</typ:unitPrice></ord:homeCurrency></ord:orderItem></ord:orderDetail></ord:order>', $lib->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $lib = $this->getLib();
        $lib->addSummary([
            'roundingDocument' => 'math2one',
            'foreignCurrency' => [
                'currency' => 'EUR',
                'rate' => '20.232',
                'amount' => 1,
                'priceSum' => 580,
            ],
        ]);

        $this->assertEquals('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderSummary><ord:roundingDocument>math2one</ord:roundingDocument><ord:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></ord:foreignCurrency></ord:orderSummary></ord:order>', $lib->getXML()->asXML());
    }

    public function testSetSummary2(): void
    {
        $lib = $this->getLib();
        $lib->setDirectionalVariable(true);
        $lib->addSummary([
            'roundingDocument' => 'math2one',
        ]);

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
        $lib = new Pohoda\Order(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->addActionType('delete', [
            'number' => '222',
        ], 'prijate_objednavky');

        $this->assertEquals('<ord:order version="2.0"><ord:actionType><ord:delete><ftr:filter agenda="prijate_objednavky"><ftr:number>222</ftr:number></ftr:filter></ord:delete></ord:actionType></ord:order>', $lib->getXML()->asXML());
    }

    public function testWithSpecialCharsIntact(): void
    {
        $lib = new Pohoda\AddressBook(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'identity' => [
                'address' => [
                    'name' => 'Călărași ñüé¿s',
                    'city' => 'Dâmbovița',
                ],
            ],
            'phone' => '123',
            'centre' => ['id' => 1],
        ]);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:addressbookHeader><adb:identity><typ:address><typ:name>Călărași ñüé¿s</typ:name><typ:city>Dâmbovița</typ:city></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre></adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<ord:orderType>receivedOrder</ord:orderType><ord:date>2015-01-10</ord:date><ord:partnerIdentity><typ:id>25</typ:id></ord:partnerIdentity><ord:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></ord:myIdentity><ord:intNote>Note</ord:intNote>';
    }

    protected function getLib(): Pohoda\Order
    {
        $lib = new Pohoda\Order(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        return $lib->setData([
            'partnerIdentity' => [
                'id' => 25,
            ],
            'myIdentity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123',
                ],
            ],
            'date' => '2015-01-10',
            'intNote' => 'Note',
        ]);
    }
}
