<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class CashSlipTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\CashSlip::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:prodejka', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader></pro:prodejka>', $this->getLib()->getXML()->asXML());
    }

    public function testAddItems(): void
    {
        $lib = $this->getLib();
        $lib->addItem([
            'text' => 'NAME 1',
            'quantity' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 200,
            ],
        ]);

        $lib->addItem([
            'quantity' => 1,
            'payVAT' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 198,
            ],
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'STM',
                ],
            ],
        ]);

        $this->assertEquals('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader><pro:prodejkaDetail><pro:prodejkaItem><pro:text>NAME 1</pro:text><pro:quantity>1</pro:quantity><pro:rateVAT>high</pro:rateVAT><pro:homeCurrency><typ:unitPrice>200</typ:unitPrice></pro:homeCurrency></pro:prodejkaItem><pro:prodejkaItem><pro:quantity>1</pro:quantity><pro:payVAT>true</pro:payVAT><pro:rateVAT>high</pro:rateVAT><pro:homeCurrency><typ:unitPrice>198</typ:unitPrice></pro:homeCurrency><pro:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pro:stockItem></pro:prodejkaItem></pro:prodejkaDetail></pro:prodejka>', $lib->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $lib = $this->getLib();
        $lib->addSummary([
            'roundingDocument' => 'math2one',
            'homeCurrency' => [
                'priceNone' => '0.0000',
                'priceLow' => '0.0000',
                'priceLowVAT' => '0.0000',
                'priceLowVatRate' => '12',
                'priceHigh' => '156.0000',
                'priceHighVAT' => '31.2000',
                'price3' => '0.0000',
                'price3VAT' => '0.0000',
                'round' => [
                    'priceRound' => '0.0000',
                ],
            ],
        ]);

        $this->assertEquals('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader><pro:prodejkaSummary><pro:roundingDocument>math2one</pro:roundingDocument><pro:homeCurrency><typ:priceNone>0</typ:priceNone><typ:price3>0</typ:price3><typ:price3VAT>0</typ:price3VAT><typ:priceLow>0</typ:priceLow><typ:priceLowVAT rate="12">0</typ:priceLowVAT><typ:priceHigh>156</typ:priceHigh><typ:priceHighVAT>31.2</typ:priceHighVAT><typ:round><typ:priceRound>0.0000</typ:priceRound></typ:round></pro:homeCurrency></pro:prodejkaSummary></pro:prodejka>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '<pro:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pro:parameters></pro:prodejkaHeader></pro:prodejka>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<pro:prodejkaType>saleVoucher</pro:prodejkaType><pro:date>2015-01-10</pro:date><pro:text>Prod</pro:text><pro:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></pro:partnerIdentity><pro:intNote>Note</pro:intNote>';
    }

    protected function getLib(): Pohoda\CashSlip
    {
        $lib = new Pohoda\CashSlip(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        return $lib->setData([
            'date' => '2015-01-10',
            'text' => 'Prod',
            'partnerIdentity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123',
                ],
            ],
            'intNote' => 'Note',
        ]);
    }
}
