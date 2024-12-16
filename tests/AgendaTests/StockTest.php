<?php

namespace AgendaTests;


use CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;


class StockTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Stock::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lStk:stock', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '</stk:stockHeader></stk:stock>', $this->getLib()->getXML()->asXML());
    }

    public function testSetActionType(): void
    {
        $lib = $this->getLib();
        $lib->addActionType('update', [
            'code' => 'CODE',
            'store' => ['ids' => 'STORAGE']
        ]);

        $this->assertEquals('<stk:stock version="2.0"><stk:actionType><stk:update><ftr:filter><ftr:code>CODE</ftr:code><ftr:store><typ:ids>STORAGE</typ:ids></ftr:store></ftr:filter></stk:update></stk:actionType><stk:stockHeader>' . $this->defaultHeader() . '</stk:stockHeader></stk:stock>', $lib->getXML()->asXML());
    }

    public function testAddStockItems(): void
    {
        $lib = $this->getLib();
        $lib->addStockItem([
            'storage' => ['ids' => 'MATERIÁL'],
            'code' => 'B03',
            'name' => 'Spojovacia doska',
            'count' => 88,
            'quantity' => 1,
            'stockPriceItem' => [
                [
                    'stockPrice' => ['ids' => 'Cena 1', 'price' => 294]
                ],
                [
                    'stockPrice' => ['ids' => 'MOC', 'price' => 393.3]
                ]
            ]
        ]);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '</stk:stockHeader><stk:stockDetail><stk:stockItem><stk:storage><typ:ids>MATERIÁL</typ:ids></stk:storage><stk:code>B03</stk:code><stk:name>Spojovacia doska</stk:name><stk:count>88</stk:count><stk:quantity>1</stk:quantity><stk:stockPriceItem><stk:stockPrice><typ:ids>Cena 1</typ:ids><typ:price>294</typ:price></stk:stockPrice><stk:stockPrice><typ:ids>MOC</typ:ids><typ:price>393.3</typ:price></stk:stockPrice></stk:stockPriceItem></stk:stockItem></stk:stockDetail></stk:stock>', $lib->getXML()->asXML());
    }

    public function testSetPrices(): void
    {
        $lib = $this->getLib();
        $lib->addPrice('Price1', 20.43);
        $lib->addPrice('Price2', 19);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '</stk:stockHeader><stk:stockPriceItem><stk:stockPrice><typ:ids>Price1</typ:ids><typ:price>20.43</typ:price></stk:stockPrice><stk:stockPrice><typ:ids>Price2</typ:ids><typ:price>19</typ:price></stk:stockPrice></stk:stockPriceItem></stk:stock>', $lib->getXML()->asXML());
    }

    public function testSetImages(): void
    {
        $lib = $this->getLib();
        $lib->addImage('image1.jpg');
        $lib->addImage('image2.jpg', 'NAME', null, true);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '<stk:pictures><stk:picture default="false"><stk:filepath>image1.jpg</stk:filepath><stk:description/><stk:order>1</stk:order></stk:picture><stk:picture default="true"><stk:filepath>image2.jpg</stk:filepath><stk:description>NAME</stk:description><stk:order>2</stk:order></stk:picture></stk:pictures></stk:stockHeader></stk:stock>', $lib->getXML()->asXML());
    }

    public function testSetCategories(): void
    {
        $lib = $this->getLib();
        $lib->addCategory(1);
        $lib->addCategory(2);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '<stk:categories><stk:idCategory>1</stk:idCategory><stk:idCategory>2</stk:idCategory></stk:categories></stk:stockHeader></stk:stock>', $lib->getXML()->asXML());
    }

    public function testSetIntParams(): void
    {
        $lib = $this->getLib();
        $lib->addIntParameter([
            'intParameterID' => 1,
            'intParameterType' => 'numberValue',
            'value' => 'VALUE1',
        ]);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '<stk:intParameters><stk:intParameter><stk:intParameterID>1</stk:intParameterID><stk:intParameterType>numberValue</stk:intParameterType><stk:intParameterValues><stk:intParameterValue><stk:parameterValue>VALUE1</stk:parameterValue></stk:intParameterValue></stk:intParameterValues></stk:intParameter></stk:intParameters></stk:stockHeader></stk:stock>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<stk:stock version="2.0"><stk:stockHeader>' . $this->defaultHeader() . '<stk:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></stk:parameters></stk:stockHeader></stk:stock>', $lib->getXML()->asXML());
    }

    protected function testDeleteStock(): void
    {
        $lib = new Pohoda\Stock(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [], '123');
        $lib->addActionType('delete', [
            'code' => 'CODE',
            'store' => ['ids' => 'STORAGE']
        ]);

        $this->assertEquals('<stk:stock version="2.0"><stk:actionType><stk:delete><ftr:filter><ftr:code>CODE</ftr:code><ftr:store><typ:ids>STORAGE</typ:ids></ftr:store></ftr:filter></stk:delete></stk:actionType></stk:stock>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<stk:stockType>card</stk:stockType><stk:code>CODE</stk:code><stk:isSales>false</stk:isSales><stk:isSerialNumber>false</stk:isSerialNumber><stk:isInternet>true</stk:isInternet><stk:name>NAME</stk:name><stk:storage><typ:ids>STORAGE</typ:ids></stk:storage><stk:typePrice><typ:id>1</typ:id></stk:typePrice><stk:sellingPrice payVAT="true">12.7</stk:sellingPrice><stk:intrastat><stk:goodsCode>123</stk:goodsCode><stk:unit>ZZZ</stk:unit><stk:coefficient>0</stk:coefficient><stk:country>CN</stk:country></stk:intrastat><stk:recyclingContrib><stk:recyclingContribType><typ:ids>X</typ:ids></stk:recyclingContribType><stk:coefficientOfRecyclingContrib>1</stk:coefficientOfRecyclingContrib></stk:recyclingContrib>';
    }

    protected function getLib(): Pohoda\Stock
    {
        return new Pohoda\Stock(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'code' => 'CODE',
            'name' => 'NAME',
            'isSales' => '0',
            'isSerialNumber' => 'false',
            'isInternet' => true,
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1],
            'sellingPrice' => 12.7,
            'sellingPricePayVAT' => true,
            'intrastat' => [
                'goodsCode' => '123',
                'unit' => 'ZZZ',
                'coefficient' => 0,
                'country' => 'CN'
            ],
            'recyclingContrib' => [
                'recyclingContribType' => 'X',
                'coefficientOfRecyclingContrib' => 1
            ]
        ], '123');
    }
}
