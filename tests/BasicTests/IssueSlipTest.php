<?php

namespace BasicTests;

use CommonTestClass;
use Riesenia\Pohoda;


class IssueSlipTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\IssueSlip::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:vydejka', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader></vyd:vydejka>', $this->getLib()->getXML()->asXML());
    }

    public function testAddItems(): void
    {
        $lib = $this->getLib();
        $lib->addItem([
            'text' => 'NAME 1',
            'quantity' => 1,
            'rateVAT' => 'high',
            'homeCurrency' => [
                'unitPrice' => 200
            ]
        ]);

        $lib->addItem([
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

        $this->assertEquals('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:vydejkaDetail><vyd:vydejkaItem><vyd:text>NAME 1</vyd:text><vyd:quantity>1</vyd:quantity><vyd:rateVAT>high</vyd:rateVAT><vyd:homeCurrency><typ:unitPrice>200</typ:unitPrice></vyd:homeCurrency></vyd:vydejkaItem><vyd:vydejkaItem><vyd:quantity>1</vyd:quantity><vyd:payVAT>true</vyd:payVAT><vyd:rateVAT>high</vyd:rateVAT><vyd:homeCurrency><typ:unitPrice>198</typ:unitPrice></vyd:homeCurrency><vyd:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></vyd:stockItem></vyd:vydejkaItem></vyd:vydejkaDetail></vyd:vydejka>', $lib->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $lib = $this->getLib();
        $lib->addSummary([
            'roundingDocument' => 'math2one',
            'foreignCurrency' => [
                'currency' => 'EUR',
                'rate' => '20.232',
                'amount' => 1,
                'priceSum' => 580
            ]
        ]);

        $this->assertEquals('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:vydejkaSummary><vyd:roundingDocument>math2one</vyd:roundingDocument><vyd:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></vyd:foreignCurrency></vyd:vydejkaSummary></vyd:vydejka>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '<vyd:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></vyd:parameters></vyd:vydejkaHeader></vyd:vydejka>', $lib->getXML()->asXML());
    }

    public function testLinkOrder(): void
    {
        $lib = $this->getLib();
        $lib->addLink([
            'sourceAgenda' => 'receivedOrder',
            'sourceDocument' => [
                'number' => '142100003'
            ]
        ]);

        $this->assertEquals('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:links><typ:link><typ:sourceAgenda>receivedOrder</typ:sourceAgenda><typ:sourceDocument><typ:number>142100003</typ:number></typ:sourceDocument></typ:link></vyd:links></vyd:vydejka>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<vyd:date>2015-01-10</vyd:date><vyd:dateOrder>2015-01-04</vyd:dateOrder><vyd:text>Vyd</vyd:text><vyd:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></vyd:partnerIdentity><vyd:intNote>Note</vyd:intNote>';
    }

    protected function getLib(): Pohoda\IssueSlip
    {
        return new Pohoda\IssueSlip([
            'date' => '2015-01-10',
            'dateOrder' => '2015-01-04',
            'text' => 'Vyd',
            'partnerIdentity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123'
                ]
            ],
            'intNote' => 'Note'
        ], '123');
    }
}
