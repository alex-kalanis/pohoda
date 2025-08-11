<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class IntDocTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\IntDoc::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:intDoc', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader></int:intDoc>', $this->getLib()->getXML()->asXML());
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

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader><int:intDocDetail><int:intDocItem><int:text>NAME 1</int:text><int:quantity>1</int:quantity><int:rateVAT>high</int:rateVAT><int:homeCurrency><typ:unitPrice>200</typ:unitPrice></int:homeCurrency></int:intDocItem></int:intDocDetail></int:intDoc>', $lib->getXML()->asXML());
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

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader><int:intDocSummary><int:roundingDocument>math2one</int:roundingDocument><int:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></int:foreignCurrency></int:intDocSummary></int:intDoc>', $lib->getXML()->asXML());
    }

    public function testTaxDocument(): void
    {
        $lib = $this->getLib();
        $lib->addTaxDocument([
            'sourceLiquidation' => [
                'sourceItemId' => '0123456879',
            ]
        ]);

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader><int:taxDocument><int:sourceLiquidation><typ:sourceItemId>123456879</typ:sourceItemId></int:sourceLiquidation></int:taxDocument></int:intDoc>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '<int:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></int:parameters></int:intDocHeader></int:intDoc>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<int:date>2015-01-10</int:date><int:partnerIdentity><typ:id>25</typ:id></int:partnerIdentity><int:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></int:myIdentity><int:intNote>Note</int:intNote>';
    }

    protected function getLib(): Pohoda\IntDoc
    {
        return new Pohoda\IntDoc(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
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
}
