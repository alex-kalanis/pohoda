<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia\Pohoda;


use PhpSpec\ObjectBehavior;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer;


class ListRequestSpec extends ObjectBehavior
{
    public function it_creates_correct_xml_for_category(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Category'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listCategoryRequest version="2.0" categoryVersion="2.0"><lst:requestCategory/></lst:listCategoryRequest>');
    }

    public function it_creates_correct_xml_for_action_prices(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'ActionPrice'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listActionPriceRequest version="2.0" actionPricesVersion="2.0"><lst:requestActionPrice/></lst:listActionPriceRequest>');
    }

    public function it_creates_correct_xml_for_order(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Order'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listOrderRequest version="2.0" orderVersion="2.0" orderType="receivedOrder"><lst:requestOrder/></lst:listOrderRequest>');
    }

    public function it_creates_correct_xml_for_advance_invoice(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Invoice',
            'invoiceType' => 'issuedAdvanceInvoice'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedAdvanceInvoice"><lst:requestInvoice/></lst:listInvoiceRequest>');
    }

    public function it_creates_correct_xml_for_vydejka(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Vydejka'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>');
    }

    public function it_creates_correct_xml_for_issue_slip(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'IssueSlip'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listVydejkaRequest version="2.0" vydejkaVersion="2.0"><lst:requestVydejka/></lst:listVydejkaRequest>');
    }

    public function it_creates_correct_xml_for_prodejka(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Prodejka'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>');
    }

    public function it_creates_correct_xml_for_cash_slip(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'CashSlip'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listProdejkaRequest version="2.0" prodejkaVersion="2.0"><lst:requestProdejka/></lst:listProdejkaRequest>');
    }

    public function it_creates_correct_xml_for_address_book(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Addressbook'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lAdb:listAddressBookRequest version="2.0" addressBookVersion="2.0"><lAdb:requestAddressBook/></lAdb:listAddressBookRequest>');
    }

    public function it_creates_correct_xml_for_int_params(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'IntParam'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listIntParamRequest version="2.0"><lst:requestIntParam/></lst:listIntParamRequest>');
    }

    public function it_creates_correct_xml_for_user_lists(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'UserList'
        ], '123');

        $this->getXML()->asXML()->shouldReturn('<lst:listUserCodeRequest version="1.1" listVersion="1.1"/>');
    }

    public function it_creates_correct_xml_for_invoice_with_user_filter_name(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Invoice'
        ], '123');

        $this->addUserFilterName('CustomFilter')->getXML()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice><ftr:userFilterName>CustomFilter</ftr:userFilterName></lst:requestInvoice></lst:listInvoiceRequest>');
    }

    public function it_creates_correct_xml_for_stock_with_complex_filter(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Stock'
        ], '123');

        $this->addFilter(['storage' => ['ids' => 'MAIN'], 'lastChanges' => '2018-04-29 14:30'])->getXML()->asXML()->shouldReturn('<lStk:listStockRequest version="2.0" stockVersion="2.0"><lStk:requestStock><ftr:filter><ftr:storage><typ:ids>MAIN</typ:ids></ftr:storage><ftr:lastChanges>2018-04-29T14:30:00</ftr:lastChanges></ftr:filter></lStk:requestStock></lStk:listStockRequest>');
    }

    /**
     * @return void
     * @see \BasicTests\ListRequestTest::testRestrict phpunit
     */
    public function it_creates_proper_restriction_data(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()),
            ['type' => 'Invoice'],
            '123'
        );

        $this->addRestrictionData(['liquidations' => true]);

        $this->getXml()->asXML()->shouldReturn('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoiceRequest>');
    }
}
