<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class InvoiceTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Invoice::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:invoice', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader></inv:invoice>', $this->getLib()->getXML()->asXML());
    }

    public function testAddItems(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\Invoice\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
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

        $item2 = new Pohoda\Invoice\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock;

        $lib->addItem($item2);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceDetail><inv:invoiceItem><inv:text>NAME 1</inv:text><inv:quantity>1</inv:quantity><inv:rateVAT>high</inv:rateVAT><inv:homeCurrency><typ:unitPrice>200</typ:unitPrice></inv:homeCurrency></inv:invoiceItem><inv:invoiceItem><inv:quantity>1</inv:quantity><inv:payVAT>true</inv:payVAT><inv:rateVAT>high</inv:rateVAT><inv:homeCurrency><typ:unitPrice>198</typ:unitPrice></inv:homeCurrency><inv:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></inv:stockItem></inv:invoiceItem></inv:invoiceDetail></inv:invoice>', $lib->getXML()->asXML());
    }

    public function testAddRecycledItem(): void
    {
        $home = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home->unitPrice = 200;

        $recycling = new Pohoda\Type\Dtos\RecyclingContribDto();
        $recycling->recyclingContribText = 'foo';
        $recycling->recyclingContribAmount = 123;

        $item = new Pohoda\Invoice\ItemDto();
        $item->text = 'NAME 1';
        $item->quantity = 1;
        $item->rateVAT = 'high';
        $item->homeCurrency = $home;
        $item->recyclingContrib = $recycling;

        $lib = $this->getLib();
        $lib->addItem($item);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceDetail><inv:invoiceItem><inv:text>NAME 1</inv:text><inv:quantity>1</inv:quantity><inv:rateVAT>high</inv:rateVAT><inv:homeCurrency><typ:unitPrice>200</typ:unitPrice></inv:homeCurrency><inv:recyclingContrib><typ:recyclingContribText>foo</typ:recyclingContribText><typ:recyclingContribAmount>123</typ:recyclingContribAmount></inv:recyclingContrib></inv:invoiceItem></inv:invoiceDetail></inv:invoice>', $lib->getXML()->asXML());
    }

    public function testAddAdvancePaymentItem(): void
    {
        $home = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home->unitPrice = -3000;
        $home->price = -3000;
        $home->priceVAT = 0;
        $home->priceSum = -3000;

        $advPayment = new Pohoda\Invoice\AdvancePaymentItemDto();
        $advPayment->sourceDocument = [
            'number' => '150800001',
        ];
        $advPayment->quantity = 1;
        $advPayment->payVAT = false;
        $advPayment->rateVAT = 'none';
        $advPayment->homeCurrency = $home;

        $lib = $this->getLib();
        $lib->addAdvancePaymentItem($advPayment);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceDetail><inv:invoiceAdvancePaymentItem><inv:sourceDocument><typ:number>150800001</typ:number></inv:sourceDocument><inv:quantity>1</inv:quantity><inv:payVAT>false</inv:payVAT><inv:rateVAT>none</inv:rateVAT><inv:homeCurrency><typ:unitPrice>-3000</typ:unitPrice><typ:price>-3000</typ:price><typ:priceVAT>0</typ:priceVAT><typ:priceSum>-3000</typ:priceSum></inv:homeCurrency></inv:invoiceAdvancePaymentItem></inv:invoiceDetail></inv:invoice>', $lib->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\Invoice\SummaryDto();
        $summary->roundingDocument = 'math2one';
        $summary->foreignCurrency = $foreign;

        $lib = $this->getLib();
        $lib->addSummary($summary);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceSummary><inv:roundingDocument>math2one</inv:roundingDocument><inv:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></inv:foreignCurrency></inv:invoiceSummary></inv:invoice>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '<inv:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></inv:parameters></inv:invoiceHeader></inv:invoice>', $lib->getXML()->asXML());
    }

    public function testLinkOrder(): void
    {
        $link = new Pohoda\Type\Dtos\LinkDto();
        $link->sourceAgenda = 'receivedOrder';
        $link->sourceDocument = [
            'number' => '142100003',
        ];

        $lib = $this->getLib();
        $lib->addLink($link);

        $this->assertEquals('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:links><typ:link><typ:sourceAgenda>receivedOrder</typ:sourceAgenda><typ:sourceDocument><typ:number>142100003</typ:number></typ:sourceDocument></typ:link></inv:links></inv:invoice>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<inv:invoiceType>issuedInvoice</inv:invoiceType><inv:date>2015-01-10</inv:date><inv:partnerIdentity><typ:id>25</typ:id></inv:partnerIdentity><inv:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></inv:myIdentity><inv:intNote>Note</inv:intNote>';
    }

    protected function getLib(): Pohoda\Invoice
    {
        $myAddr = new Pohoda\Type\Dtos\AddressInternetTypeDto();
        $myAddr->name = 'NAME';
        $myAddr->ico = '123';

        $myIdentity = new Pohoda\Type\Dtos\MyAddressDto();
        $myIdentity->address = $myAddr;

        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 25;

        $header = new Pohoda\Invoice\HeaderDto();
        $header->date = '2015-01-10';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;
        $header->myIdentity = $myIdentity;

        $dto = new Pohoda\Invoice\InvoiceDto();
        $dto->header = $header;

        $lib = new Pohoda\Invoice($this->getBasicDi());
        return $lib->setData($dto);
    }
}
