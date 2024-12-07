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

class InvoiceSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith([
            'partnerIdentity' => [
                'id' => 25
            ],
            'myIdentity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123'
                ]
            ],
            'date' => '2015-01-10',
            'intNote' => 'Note'
        ], '123');
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\Invoice');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader></inv:invoice>');
    }

    public function it_can_add_items(): void
    {
        $this->addItem([
            'text' => 'NAME 1',
            'quantity' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 200
            ]
        ]);

        $this->addItem([
            'quantity' => 1,
            'payVAT' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 198
            ],
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'STM'
                ]
            ]
        ]);

        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceDetail><inv:invoiceItem><inv:text>NAME 1</inv:text><inv:quantity>1</inv:quantity><inv:rateVAT>high</inv:rateVAT><inv:homeCurrency><typ:unitPrice>200</typ:unitPrice></inv:homeCurrency></inv:invoiceItem><inv:invoiceItem><inv:quantity>1</inv:quantity><inv:payVAT>true</inv:payVAT><inv:rateVAT>high</inv:rateVAT><inv:homeCurrency><typ:unitPrice>198</typ:unitPrice></inv:homeCurrency><inv:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></inv:stockItem></inv:invoiceItem></inv:invoiceDetail></inv:invoice>');
    }

    public function it_can_add_advance_payment_item(): void
    {
        $this->addAdvancePaymentItem([
            'sourceDocument' => [
                'number' => '150800001'
            ],
            'quantity' => 1,
            'payVAT' => false,
            'rateVAT' => 'none',
            'homeCurrency' => [
                'unitPrice' => -3000,
                'price' => -3000,
                'priceVAT' => 0,
                'priceSum' => -3000
            ]
        ]);

        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceDetail><inv:invoiceAdvancePaymentItem><inv:sourceDocument><typ:number>150800001</typ:number></inv:sourceDocument><inv:quantity>1</inv:quantity><inv:payVAT>false</inv:payVAT><inv:rateVAT>none</inv:rateVAT><inv:homeCurrency><typ:unitPrice>-3000</typ:unitPrice><typ:price>-3000</typ:price><typ:priceVAT>0</typ:priceVAT><typ:priceSum>-3000</typ:priceSum></inv:homeCurrency></inv:invoiceAdvancePaymentItem></inv:invoiceDetail></inv:invoice>');
    }

    public function it_can_set_summary(): void
    {
        $this->addSummary([
            'roundingDocument' => 'math2one',
            'foreignCurrency' => [
                'currency' => 'EUR',
                'rate' => '20.232',
                'amount' => 1,
                'priceSum' => 580
            ]
        ]);

        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:invoiceSummary><inv:roundingDocument>math2one</inv:roundingDocument><inv:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></inv:foreignCurrency></inv:invoiceSummary></inv:invoice>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '<inv:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></inv:parameters></inv:invoiceHeader></inv:invoice>');
    }

    public function it_can_link_to_order(): void
    {
        $this->addLink([
            'sourceAgenda' => 'receivedOrder',
            'sourceDocument' => [
                'number' => '142100003'
            ]
        ]);

        $this->getXML()->asXML()->shouldReturn('<inv:invoice version="2.0"><inv:invoiceHeader>' . $this->defaultHeader() . '</inv:invoiceHeader><inv:links><typ:link><typ:sourceAgenda>receivedOrder</typ:sourceAgenda><typ:sourceDocument><typ:number>142100003</typ:number></typ:sourceDocument></typ:link></inv:links></inv:invoice>');
    }

    protected function defaultHeader(): string
    {
        return '<inv:invoiceType>issuedInvoice</inv:invoiceType><inv:date>2015-01-10</inv:date><inv:partnerIdentity><typ:id>25</typ:id></inv:partnerIdentity><inv:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></inv:myIdentity><inv:intNote>Note</inv:intNote>';
    }
}
