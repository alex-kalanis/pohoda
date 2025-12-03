<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

class ListRequestTest extends CommonTestClass
{
    public function testCategory(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Category';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listCategoryRequest version="2.0" categoryVersion="2.0"><lst:requestCategory/></lst:listCategoryRequest>', $lib->getXML()->asXML());
        // $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testActionPrice(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'ActionPrice';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listActionPriceRequest version="2.0" actionPricesVersion="2.0"><lst:requestActionPrice/></lst:listActionPriceRequest>', $lib->getXML()->asXML());
    }

    public function testOrder(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Order';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder/></lst:listOrderRequest>', $lib->getXML()->asXML());
    }

    public function testOrderQuery(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Order';

        $queryFilter = new Pohoda\ListRequest\QueryFilterDto();
        $queryFilter->filter = '(direct SQL to DB in Pohoda)';
        $queryFilter->textName = 'Text desc of the call';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $lib->addQueryFilter($queryFilter);
        $this->assertEquals('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder><ftr:queryFilter><ftr:filter>(direct SQL to DB in Pohoda)</ftr:filter><ftr:textName>Text desc of the call</ftr:textName></ftr:queryFilter></lst:requestOrder></lst:listOrderRequest>', $lib->getXML()->asXML());
    }

    public function testAdvanceInvoice(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';
        $dto->invoiceType = Pohoda\Common\Enums\InvoiceTypeEnum::IssuedAdvanceInvoice;

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice"><lst:requestInvoice/></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }

    public function testVydejka(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Vydejka';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>', $lib->getXML()->asXML());
    }

    public function testIssueSlip(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'IssueSlip';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>', $lib->getXML()->asXML());
    }

    public function testProdejka(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Prodejka';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>', $lib->getXML()->asXML());
    }

    public function testCashSlip(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'CashSlip';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>', $lib->getXML()->asXML());
    }

    public function testAddressBook(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Addressbook';

        $limit = new Pohoda\ListRequest\LimitDto();
        $limit->idFrom = 123456;
        $limit->count = 333;

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook/></lAdb:listAddressBookRequest>', $lib->getXML()->asXML());
        $lib->addLimit($limit);
        $this->assertEquals('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook><ftr:limit><ftr:idFrom>123456</ftr:idFrom><ftr:count>333</ftr:count></ftr:limit></lAdb:requestAddressBook></lAdb:listAddressBookRequest>', $lib->getXML()->asXML());
        // $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testInitParams(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'IntParam';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listIntParamRequest version="2.0"><lst:requestIntParam/></lst:listIntParamRequest>', $lib->getXML()->asXML());
    }

    public function testUserList(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'UserList';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listUserCodeRequest version="1.1" listVersion="1.1"/>', $lib->getXML()->asXML());
    }

    public function testInvoiceWithFilterName(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $lib->addUserFilterName(Pohoda\ListRequest\UserFilterNameDto::init('CustomFilter'));
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }

    public function testStockWithComplexFilter(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Stock';

        $filter = new Pohoda\ListRequest\FilterDto();
        $filter->storage = ['ids' => 'MAIN'];
        $filter->lastChanges = '2018-04-29 14:30';

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $lib->addFilter($filter);
        $this->assertEquals('<lStk:listStockRequest version="2.0" stockVersion="2.0"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStockRequest>', $lib->getXML()->asXML());
    }

    public function testRestrict(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';

        $restriction = new Pohoda\ListRequest\RestrictionDataDto();
        $restriction->liquidations = true;

        $lib = new Pohoda\ListRequest($this->getBasicDi());
        $lib->setData($dto);
        $lib->addRestrictionData($restriction);
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }
}
