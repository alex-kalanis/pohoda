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
        $lib = $this->getLib();
        $lib->addSummary([
            'homeCurrency' => [
                'priceNone' => 500,
            ],
        ]);

        $this->assertEquals('<vch:voucher version="2.0"><vch:voucherHeader>' . $this->defaultHeader() . '</vch:voucherHeader><vch:voucherSummary><vch:homeCurrency><typ:priceNone>500</typ:priceNone></vch:homeCurrency></vch:voucherSummary></vch:voucher>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
    {
        $lib = $this->getLib();
        $lib->addItem([
            'text' => 'test one',
            'quantity' => 369,
            'unit' => 2,
            'homeCurrency' => [
                'unitPrice' => 153,
            ],
            'note' => 'testing one',
        ]);
        $lib->addItem([
            'text' => 'test two',
            'quantity' => 42,
            'unit' => 816,
            'homeCurrency' => [
                'price' => 816,
            ],
            'note' => 'testing two',
        ]);

        $this->assertEquals('<vch:voucher version="2.0"><vch:voucherHeader>' . $this->defaultHeader() . '</vch:voucherHeader><vch:voucherDetail><vch:voucherItem><vch:text>test one</vch:text><vch:quantity>369</vch:quantity><vch:unit>2</vch:unit><vch:homeCurrency><typ:unitPrice>153</typ:unitPrice></vch:homeCurrency><vch:note>testing one</vch:note></vch:voucherItem><vch:voucherItem><vch:text>test two</vch:text><vch:quantity>42</vch:quantity><vch:unit>816</vch:unit><vch:homeCurrency><typ:price>816</typ:price></vch:homeCurrency><vch:note>testing two</vch:note></vch:voucherItem></vch:voucherDetail></vch:voucher>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<vch:id>123456</vch:id>';
    }

    protected function getLib(): Pohoda\Voucher
    {
        $lib = new Pohoda\Voucher($this->getBasicDi());
        return $lib->setData([
            'id' => '123456',
        ]);
    }
}
