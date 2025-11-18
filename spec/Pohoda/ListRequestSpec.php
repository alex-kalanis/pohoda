<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class ListRequestSpec extends ObjectBehavior
{
    use DiTrait;

    public function it_creates_correct_xml_for_category(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Category';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listCategoryRequest version="2.0" categoryVersion="2.0"><lst:requestCategory/></lst:listCategoryRequest>');
    }

    public function it_creates_correct_xml_for_action_prices(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'ActionPrice';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listActionPriceRequest version="2.0" actionPricesVersion="2.0"><lst:requestActionPrice/></lst:listActionPriceRequest>');
    }

    public function it_creates_correct_xml_for_order(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Order';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder/></lst:listOrderRequest>');
    }

    public function it_creates_correct_xml_for_advance_invoice(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';
        $dto->invoiceType = 'issuedAdvanceInvoice';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice"><lst:requestInvoice/></lst:listInvoiceRequest>');
    }

    public function it_creates_correct_xml_for_vydejka(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Vydejka';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>');
    }

    public function it_creates_correct_xml_for_issue_slip(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'IssueSlip';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>');
    }

    public function it_creates_correct_xml_for_prodejka(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Prodejka';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>');
    }

    public function it_creates_correct_xml_for_cash_slip(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'CashSlip';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>');
    }

    public function it_creates_correct_xml_for_address_book(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Addressbook';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook/></lAdb:listAddressBookRequest>');
    }

    public function it_creates_correct_xml_for_int_params(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'IntParam';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listIntParamRequest version="2.0"><lst:requestIntParam/></lst:listIntParamRequest>');
    }

    public function it_creates_correct_xml_for_user_lists(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'UserList';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<lst:listUserCodeRequest version="1.1" listVersion="1.1"/>');
    }

    public function it_creates_correct_xml_for_invoice_with_user_filter_name(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->addUserFilterName(Pohoda\ListRequest\UserFilterNameDto::init('CustomFilter'))->getXML()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoiceRequest>');
    }

    public function it_creates_correct_xml_for_stock_with_complex_filter(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Stock';

        $filter = new Pohoda\ListRequest\FilterDto();
        $filter->storage = ['ids' => 'MAIN'];
        $filter->lastChanges = '2018-04-29 14:30';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->addFilter($filter)->getXML()->asXML()->shouldReturn('<lStk:listStockRequest version="2.0" stockVersion="2.0"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStockRequest>');
    }

    /**
     * @return void
     * @see \tests\BasicTests\ListRequestTest::testRestrict phpunit
     */
    public function it_creates_proper_restriction_data(): void
    {
        $dto = new Pohoda\ListRequest\ListRequestDto();
        $dto->type = 'Invoice';

        $restriction = new Pohoda\ListRequest\RestrictionDataDto();
        $restriction->liquidations = true;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->addRestrictionData($restriction);

        $this->getXml()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoiceRequest>');
    }
}
