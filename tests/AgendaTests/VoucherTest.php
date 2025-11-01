<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class VoucherTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Voucher::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('vch:voucher', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<vch:voucher version="2.0"><vch:voucherHeader>' . $this->defaultHeader() . '</vch:voucherHeader></vch:voucher>', $this->getLib()->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $currency = new Pohoda\Type\Dtos\CurrencyHomeDto();
        $currency->priceNone = 500;
        $summaryDto = new Pohoda\Voucher\SummaryDto();
        $summaryDto->homeCurrency = $currency;

        $lib = $this->getLib();
        $lib->addSummary($summaryDto);

        $this->assertEquals('<vch:voucher version="2.0"><vch:voucherHeader>' . $this->defaultHeader() . '</vch:voucherHeader><vch:voucherSummary><vch:homeCurrency><typ:priceNone>500</typ:priceNone></vch:homeCurrency></vch:voucherSummary></vch:voucher>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
    {
        $currency1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $currency1->unitPrice = 153;
        $itemDto1 = new Pohoda\Voucher\ItemDto();
        $itemDto1->text = 'test one';
        $itemDto1->quantity = 369;
        $itemDto1->unit = 2;
        $itemDto1->note = 'testing one';
        $itemDto1->homeCurrency = $currency1;

        $currency2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $currency2->price = 816;
        $itemDto2 = new Pohoda\Voucher\ItemDto();
        $itemDto2->text = 'test two';
        $itemDto2->quantity = 42;
        $itemDto2->unit = 816;
        $itemDto2->note = 'testing two';
        $itemDto2->homeCurrency = $currency2;

        $lib = $this->getLib();
        $lib->addItem($itemDto1);
        $lib->addItem($itemDto2);

        $this->assertEquals('<vch:voucher version="2.0"><vch:voucherHeader>' . $this->defaultHeader() . '</vch:voucherHeader><vch:voucherDetail><vch:voucherItem><vch:text>test one</vch:text><vch:quantity>369</vch:quantity><vch:unit>2</vch:unit><vch:homeCurrency><typ:unitPrice>153</typ:unitPrice></vch:homeCurrency><vch:note>testing one</vch:note></vch:voucherItem><vch:voucherItem><vch:text>test two</vch:text><vch:quantity>42</vch:quantity><vch:unit>816</vch:unit><vch:homeCurrency><typ:price>816</typ:price></vch:homeCurrency><vch:note>testing two</vch:note></vch:voucherItem></vch:voucherDetail></vch:voucher>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<vch:id>123456</vch:id>';
    }

    protected function getLib(): Pohoda\Voucher
    {
        $base = new Pohoda\Common\Dtos\AgendaDto();
        $header = new Pohoda\Voucher\HeaderDto();
        $header->id = '123456';
        $base->header = $header;
        $lib = new Pohoda\Voucher($this->getBasicDi());
        return $lib->setData($base);
    }
}
