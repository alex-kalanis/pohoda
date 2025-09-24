<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class ListResponseTest extends CommonTestClass
{
    public function testCategory(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Category',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listCategory version="2.0" categoryVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestCategory/></lst:listCategory>', $lib->getXML()->asXML());
    }

    public function testActionPrice(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'ActionPrice',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listActionPrice version="2.0" actionPricesVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestActionPrice/></lst:listActionPrice>', $lib->getXML()->asXML());
    }

    public function testOrder(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Order',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listOrder version="2.0" orderType="receivedOrder" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestOrder/></lst:listOrder>', $lib->getXML()->asXML());
    }

    public function testOrder2(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setDirectionAsResponse(true);
        $lib->setDirectionalVariable(true);
        $lib->setData([
            'type' => 'Order',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $order = $lib->addOrder([
            'id' => 0,
            'orderType' => 'receivedOrder',
            'number' => [
                'id' => '1234567890',
            ],
            'numberOrder' => '1234567890',
            'date' => date_create_immutable('2025-07-01T01:00:00'),
            'isExecuted' => 'false',
        ], [
            [
                'id' => '1',
                'text' => 'foo bar',
                'code' => 'baz',
                'quantity' => sprintf('%01.2f', 2.0),
                'delivered' => '0.0',
                'unit' => 'pcs',
                'coefficient' => '1.0',
                'payVAT' => 'true',
                'PDP' => 'false',
            ],
        ], [
            'roundingDocument' => 'none',
            'roundingVAT' => 'none',
        ]);
        $order->setDirectionAsResponse(true);
        $this->assertEquals('<lst:listOrder version="2.0" orderType="receivedOrder" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:order version="2.0"><ord:orderHeader><ord:orderType>receivedOrder</ord:orderType><ord:number><typ:id>1234567890</typ:id></ord:number><ord:numberOrder>1234567890</ord:numberOrder><ord:date>2025-07-01</ord:date><ord:isExecuted>false</ord:isExecuted><ord:id>0</ord:id></ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>foo bar</ord:text><ord:quantity>2</ord:quantity><ord:delivered>0</ord:delivered><ord:unit>pcs</ord:unit><ord:coefficient>1</ord:coefficient><ord:payVAT>true</ord:payVAT><ord:code>baz</ord:code><ord:PDP>false</ord:PDP><ord:id>1</ord:id></ord:orderItem></ord:orderDetail><ord:orderSummary><ord:roundingDocument>none</ord:roundingDocument><ord:roundingVAT>none</ord:roundingVAT></ord:orderSummary></lst:order></lst:listOrder>', $lib->getXML()->asXML());
    }

    public function testAdvanceInvoice(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Invoice',
            'invoiceType' => 'issuedAdvanceInvoice',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestInvoice/></lst:listInvoice>', $lib->getXML()->asXML());
    }

    public function testVydejka(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Vydejka',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listVydejka version="2.0" vydejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestVydejka/></lst:listVydejka>', $lib->getXML()->asXML());
    }

    public function testIssueSlip(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'IssueSlip',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listVydejka version="2.0" vydejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestVydejka/></lst:listVydejka>', $lib->getXML()->asXML());
    }

    public function testProdejka(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Prodejka',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listProdejka version="2.0" prodejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestProdejka/></lst:listProdejka>', $lib->getXML()->asXML());
    }

    public function testCashSlip(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'CashSlip',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listProdejka version="2.0" prodejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lst:requestProdejka/></lst:listProdejka>', $lib->getXML()->asXML());
    }

    public function testAddressBook(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'AddressBook',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lAdb:listAddressBook version="2.0" addressBookVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lAdb:requestAddressBook/></lAdb:listAddressBook>', $lib->getXML()->asXML());
        //        $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testInitParams(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'IntParam',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listIntParam version="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestIntParam/></lst:listIntParam>', $lib->getXML()->asXML());
    }

    public function testContract(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Contract',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $lib->addLimit([
            'idFrom' => 123456,
            'count' => 333,
        ]);
        $this->assertEquals('<lCon:listContract version="2.0" contractVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lCon:requestContract><ftr:limit><ftr:idFrom>123456</ftr:idFrom><ftr:count>333</ftr:count></ftr:limit></lCon:requestContract></lCon:listContract>', $lib->getXML()->asXML());
    }

    public function testUserList(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'UserList',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $this->assertEquals('<lst:listUserCodeResponse version="1.1" listVersion="1.1" dateTimeStamp="2025-07-01T01:00:00" state="ok"/>', $lib->getXML()->asXML());
    }

    public function testInvoiceWithFilterName(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Invoice',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'state' => 'ok',
        ]);
        $lib->addUserFilterName('CustomFilter');
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoice>', $lib->getXML()->asXML());
    }

    public function testStockWithComplexFilter(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Stock',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ]);
        $lib->addFilter(['storage' => ['ids' => 'MAIN'], 'lastChanges' => date_create_immutable('2018-04-29T14:30:00')]);
        $this->assertEquals('<lStk:listStock version="2.0" stockVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStock>', $lib->getXML()->asXML());
    }

    public function testRestrict(): void
    {
        $lib = new Pohoda\ListResponse(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'type' => 'Invoice',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ]);
        $lib->addRestrictionData(['liquidations' => true]);
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoice>', $lib->getXML()->asXML());
    }
}
