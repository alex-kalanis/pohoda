<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

class ListResponseTest extends CommonTestClass
{
    public function testCategory(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Category';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listCategory version="2.0" categoryVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestCategory/></lst:listCategory>', $lib->getXML()->asXML());
    }

    public function testActionPrice(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'ActionPrice';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listActionPrice version="2.0" actionPricesVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestActionPrice/></lst:listActionPrice>', $lib->getXML()->asXML());
    }

    public function testOrder(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Order';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listOrder version="2.0" orderType="receivedOrder" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestOrder/></lst:listOrder>', $lib->getXML()->asXML());
    }

    public function testOrder2(): void
    {
        $orderHeader = new Pohoda\Order\HeaderDto();
        $orderHeader->id = 0;
        $orderHeader->orderType = 'receivedOrder';
        $orderHeader->number = [
            'id' => '1234567890',
        ];
        $orderHeader->numberOrder = '1234567890';
        $orderHeader->date = date_create_immutable('2025-07-01T01:00:00');
        $orderHeader->isExecuted = 'false';

        $orderSummary = new Pohoda\Order\SummaryDto();
        $orderSummary->roundingDocument = Pohoda\Common\Enums\RoundingDocumentEnum::None;
        $orderSummary->roundingVAT = Pohoda\Common\Enums\RoundingVatEnum::None;

        $orderDto = new Pohoda\Order\OrderDto();
        $orderDto->header = $orderHeader;

        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Order';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $item1 = new Pohoda\Order\ItemDto();
        $item1->id = '1';
        $item1->text = 'foo bar';
        $item1->code = 'baz';
        $item1->quantity = sprintf('%01.2f', 2.0);
        $item1->delivered = '0.0';
        $item1->unit = 'pcs';
        $item1->coefficient = '1.0';
        $item1->payVAT = true;
        $item1->PDP = false;

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setDirectionAsResponse(true);
        $lib->setDirectionalVariable(true);
        $lib->setData($dto);
        $order = $lib->addOrder($orderDto, [$item1,], $orderSummary);
        $order->setDirectionAsResponse(true);
        $this->assertEquals('<lst:listOrder version="2.0" orderType="receivedOrder" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:order version="2.0"><ord:orderHeader><ord:orderType>receivedOrder</ord:orderType><ord:number><typ:id>1234567890</typ:id></ord:number><ord:numberOrder>1234567890</ord:numberOrder><ord:date>2025-07-01</ord:date><ord:isExecuted>false</ord:isExecuted><ord:id>0</ord:id></ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>foo bar</ord:text><ord:quantity>2</ord:quantity><ord:delivered>0</ord:delivered><ord:unit>pcs</ord:unit><ord:coefficient>1</ord:coefficient><ord:payVAT>true</ord:payVAT><ord:code>baz</ord:code><ord:PDP>false</ord:PDP><ord:id>1</ord:id></ord:orderItem></ord:orderDetail><ord:orderSummary><ord:roundingDocument>none</ord:roundingDocument><ord:roundingVAT>none</ord:roundingVAT></ord:orderSummary></lst:order></lst:listOrder>', $lib->getXML()->asXML());
    }

    public function testAdvanceInvoice(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Invoice';
        $dto->invoiceType = 'issuedAdvanceInvoice';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestInvoice/></lst:listInvoice>', $lib->getXML()->asXML());
    }

    public function testVydejka(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Vydejka';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listVydejka version="2.0" vydejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestVydejka/></lst:listVydejka>', $lib->getXML()->asXML());
    }

    public function testIssueSlip(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'IssueSlip';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listVydejka version="2.0" vydejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestVydejka/></lst:listVydejka>', $lib->getXML()->asXML());
    }

    public function testProdejka(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Prodejka';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listProdejka version="2.0" prodejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestProdejka/></lst:listProdejka>', $lib->getXML()->asXML());
    }

    public function testCashSlip(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'CashSlip';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->validFrom = date_create_immutable('2025-07-01');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listProdejka version="2.0" prodejkaVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lst:requestProdejka/></lst:listProdejka>', $lib->getXML()->asXML());
    }

    public function testAddressBook(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'AddressBook';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lAdb:listAddressBook version="2.0" addressBookVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lAdb:requestAddressBook/></lAdb:listAddressBook>', $lib->getXML()->asXML());
        // $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testInitParams(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'IntParam';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listIntParam version="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestIntParam/></lst:listIntParam>', $lib->getXML()->asXML());
    }

    public function testContract(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Contract';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $limit = new Pohoda\ListRequest\LimitDto();
        $limit->idFrom = 123456;
        $limit->count = 333;

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $lib->addLimit($limit);
        $this->assertEquals('<lCon:listContract version="2.0" contractVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lCon:requestContract><ftr:limit><ftr:idFrom>123456</ftr:idFrom><ftr:count>333</ftr:count></ftr:limit></lCon:requestContract></lCon:listContract>', $lib->getXML()->asXML());
    }

    public function testUserList(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'UserList';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<lst:listUserCodeResponse version="1.1" listVersion="1.1" dateTimeStamp="2025-07-01T01:00:00" state="ok"/>', $lib->getXML()->asXML());
    }

    public function testInvoiceWithFilterName(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Invoice';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $lib->addUserFilterName(Pohoda\ListRequest\UserFilterNameDto::init('CustomFilter'));
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice" dateTimeStamp="2025-07-01T01:00:00" state="ok"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoice>', $lib->getXML()->asXML());
    }

    public function testStockWithComplexFilter(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Stock';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->validFrom = date_create_immutable('2025-07-01');
        $dto->state = 'ok';

        $filter = new Pohoda\ListRequest\FilterDto();
        $filter->storage = ['ids' => 'MAIN'];
        $filter->lastChanges = date_create_immutable('2018-04-29T14:30:00');

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $lib->addFilter($filter);
        $this->assertEquals('<lStk:listStock version="2.0" stockVersion="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStock>', $lib->getXML()->asXML());
    }

    public function testStockWithResponseData(): void
    {
        $stockHeader = new Pohoda\Stock\HeaderDto();
        $stockHeader->id = 1999;
        $stockHeader->stockType = Pohoda\Stock\StockTypeEnum::Card;
        $stockHeader->code = '123456';
        $stockHeader->isSales = false;
        $stockHeader->isInternet = false;
        $stockHeader->purchasingRateVAT = Pohoda\Common\Enums\RateVatEnum::None;
        $stockHeader->purchasingRatePayVAT = 0;
        $stockHeader->sellingRateVAT = Pohoda\Common\Enums\RateVatEnum::None;
        $stockHeader->sellingRatePayVAT = 0;
        $stockHeader->name = 'Dummy object';
        $stockHeader->unit = 'ks';
        $stockHeader->storage = [
            'id' => '1',
            'ids' => '01',
        ];
        $stockHeader->typePrice = [
            'id' => '01',
            'ids' => 'ACC',
        ];
        $stockHeader->weightedPurchasePrice = 0;
        $stockHeader->sellingPrice = 400;
        $stockHeader->fixation = 'sellingPrice';
        $stockHeader->count = 0.0;
        $stockHeader->countIssue = 0.0;
        $stockHeader->countReceivedOrders = 0.0;
        $stockHeader->reservation = 0.0;
        $stockHeader->reclamation = 0.0;
        $stockHeader->service = 0.0;
        $stockHeader->orderQuantity = 0.0;
        $stockHeader->countIssuedOrders = 0.0;
        $stockHeader->news = false;
        $stockHeader->clearanceSale = false;
        $stockHeader->sale = false;
        $stockHeader->recommended = false;
        $stockHeader->discount = false;
        $stockHeader->prepare = false;
        $stockHeader->controlLimitTaxLiability = false;
        $stockHeader->description = 'This one is longer with escaped HTML elements';
        $stockHeader->markRecord = true;

        $stockDto = new Pohoda\Stock\StockDto();
        $stockDto->header = $stockHeader;

        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Stock';
        $dto->timestamp = date_create_immutable('2025-09-01T10:00:00');
        $dto->validFrom = date_create_immutable('2025-09-01');
        $dto->state = 'ok';

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setDirectionalVariable(true);
        $lib->setData($dto);
        $stock = $lib->addStock($stockDto);
        $stock->addPrice('Sleva 1', 111, 2);
        $stock->addPrice('Prodejní', 150, 1);
        $this->assertEquals('<lStk:listStock version="2.0" dateTimeStamp="2025-09-01T10:00:00" dateValidFrom="2025-09-01" state="ok"><lStk:stock version="2.0"><stk:stockHeader><stk:stockType>card</stk:stockType><stk:code>123456</stk:code><stk:isSales>false</stk:isSales><stk:isInternet>false</stk:isInternet><stk:purchasingRateVAT value="0">none</stk:purchasingRateVAT><stk:sellingRateVAT value="0">none</stk:sellingRateVAT><stk:name>Dummy object</stk:name><stk:unit>ks</stk:unit><stk:storage><typ:id>1</typ:id><typ:ids>01</typ:ids></stk:storage><stk:typePrice><typ:id>01</typ:id><typ:ids>ACC</typ:ids></stk:typePrice><stk:sellingPrice>400</stk:sellingPrice><stk:orderQuantity>0</stk:orderQuantity><stk:description>This one is longer with escaped HTML elements</stk:description><stk:id>1999</stk:id><stk:weightedPurchasePrice>0</stk:weightedPurchasePrice><stk:count>0</stk:count><stk:countIssue>0</stk:countIssue><stk:countReceivedOrders>0</stk:countReceivedOrders><stk:reservation>0</stk:reservation><stk:countIssuedOrders>0</stk:countIssuedOrders><stk:clearanceSale>false</stk:clearanceSale><stk:controlLimitTaxLiability>false</stk:controlLimitTaxLiability><stk:discount>false</stk:discount><stk:fixation>sellingPrice</stk:fixation><stk:markRecord>true</stk:markRecord><stk:news>false</stk:news><stk:prepare>false</stk:prepare><stk:recommended>false</stk:recommended><stk:sale>false</stk:sale><stk:reclamation>0</stk:reclamation><stk:service>0</stk:service></stk:stockHeader><stk:stockPriceItem><stk:stockPrice><typ:id>2</typ:id><typ:ids>Sleva 1</typ:ids><typ:price>111</typ:price></stk:stockPrice><stk:stockPrice><typ:id>1</typ:id><typ:ids>Prodejní</typ:ids><typ:price>150</typ:price></stk:stockPrice></stk:stockPriceItem></lStk:stock></lStk:listStock>', $lib->getXML()->asXML());
    }

    public function testRestrict(): void
    {
        $dto = new Pohoda\ListResponse\ListResponseDto();
        $dto->type = 'Invoice';
        $dto->timestamp = date_create_immutable('2025-07-01T01:00:00');
        $dto->validFrom = date_create_immutable('2025-07-01');
        $dto->state = 'ok';

        $restriction = new Pohoda\ListRequest\RestrictionDataDto();
        $restriction->liquidations = true;

        $lib = new Pohoda\ListResponse($this->getBasicDi());
        $lib->setData($dto);
        $lib->addRestrictionData($restriction);
        $this->assertEquals('<lst:listInvoice version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoice>', $lib->getXML()->asXML());
    }
}
