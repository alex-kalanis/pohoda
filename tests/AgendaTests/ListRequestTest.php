<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class ListRequestTest extends CommonTestClass
{
    public function testCategory(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Category']);
        $this->assertEquals('<lst:listCategoryRequest version="2.0" categoryVersion="2.0"><lst:requestCategory/></lst:listCategoryRequest>', $lib->getXML()->asXML());
        //        $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testActionPrice(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'ActionPrice']);
        $this->assertEquals('<lst:listActionPriceRequest version="2.0" actionPricesVersion="2.0"><lst:requestActionPrice/></lst:listActionPriceRequest>', $lib->getXML()->asXML());
    }

    public function testOrder(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Order']);
        $this->assertEquals('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder/></lst:listOrderRequest>', $lib->getXML()->asXML());
    }

    public function testOrderQuery(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Order']);
        $lib->addQueryFilter(['filter' => '(direct SQL to DB in Pohoda)', 'textName' => 'Text desc of the call']);
        $this->assertEquals('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder><ftr:queryFilter><ftr:filter>(direct SQL to DB in Pohoda)</ftr:filter><ftr:textName>Text desc of the call</ftr:textName></ftr:queryFilter></lst:requestOrder></lst:listOrderRequest>', $lib->getXML()->asXML());
    }

    public function testAdvanceInvoice(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Invoice', 'invoiceType' => 'issuedAdvanceInvoice']);
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice"><lst:requestInvoice/></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }

    public function testVydejka(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Vydejka']);
        $this->assertEquals('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>', $lib->getXML()->asXML());
    }

    public function testIssueSlip(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'IssueSlip']);
        $this->assertEquals('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>', $lib->getXML()->asXML());
    }

    public function testProdejka(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Prodejka']);
        $this->assertEquals('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>', $lib->getXML()->asXML());
    }

    public function testCashSlip(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'CashSlip']);
        $this->assertEquals('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>', $lib->getXML()->asXML());
    }

    public function testAddressBook(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Addressbook']);
        $this->assertEquals('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook/></lAdb:listAddressBookRequest>', $lib->getXML()->asXML());
        $lib->addLimit([
            'idFrom' => 123456,
            'count' => 333,
        ]);
        $this->assertEquals('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook><ftr:limit><ftr:idFrom>123456</ftr:idFrom><ftr:count>333</ftr:count></ftr:limit></lAdb:requestAddressBook></lAdb:listAddressBookRequest>', $lib->getXML()->asXML());
        //        $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testInitParams(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'IntParam']);
        $this->assertEquals('<lst:listIntParamRequest version="2.0"><lst:requestIntParam/></lst:listIntParamRequest>', $lib->getXML()->asXML());
    }

    public function testUserList(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'UserList']);
        $this->assertEquals('<lst:listUserCodeRequest version="1.1" listVersion="1.1"/>', $lib->getXML()->asXML());
    }

    public function testInvoiceWithFilterName(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Invoice']);
        $lib->addUserFilterName('CustomFilter');
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }

    public function testStockWithComplexFilter(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Stock']);
        $lib->addFilter(['storage' => ['ids' => 'MAIN'], 'lastChanges' => '2018-04-29 14:30']);
        $this->assertEquals('<lStk:listStockRequest version="2.0" stockVersion="2.0"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStockRequest>', $lib->getXML()->asXML());
    }

    public function testRestrict(): void
    {
        $lib = new Pohoda\ListRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData(['type' => 'Invoice']);
        $lib->addRestrictionData(['liquidations' => true]);
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }
}
