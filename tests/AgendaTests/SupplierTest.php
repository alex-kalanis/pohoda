<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class SupplierTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Supplier::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:supplier', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<sup:supplier version="2.0"><sup:stockItem><typ:stockItem><typ:ids>B04</typ:ids></typ:stockItem></sup:stockItem><sup:suppliers><sup:supplierItem default="true"><sup:refAd><typ:id>2</typ:id></sup:refAd><sup:orderCode>A1</sup:orderCode><sup:orderName>A-zasoba</sup:orderName><sup:purchasingPrice>1968</sup:purchasingPrice><sup:rate>0</sup:rate><sup:payVAT>false</sup:payVAT><sup:ean>11112228</sup:ean><sup:printEAN>true</sup:printEAN><sup:unitEAN>ks</sup:unitEAN><sup:unitCoefEAN>1</sup:unitCoefEAN><sup:deliveryTime>12</sup:deliveryTime><sup:minQuantity>2</sup:minQuantity><sup:note>fdf</sup:note></sup:supplierItem><sup:supplierItem default="false"><sup:refAd><typ:ids>INTEAK spol. s r. o.</typ:ids></sup:refAd><sup:orderCode>I1</sup:orderCode><sup:orderName>I-zasoba</sup:orderName><sup:purchasingPrice>500</sup:purchasingPrice><sup:rate>0</sup:rate><sup:payVAT>false</sup:payVAT><sup:ean>212121212</sup:ean><sup:printEAN>true</sup:printEAN><sup:unitEAN>ks</sup:unitEAN><sup:unitCoefEAN>1</sup:unitCoefEAN><sup:deliveryTime>12</sup:deliveryTime><sup:minQuantity>2</sup:minQuantity><sup:note>aasn</sup:note></sup:supplierItem></sup:suppliers></sup:supplier>', $this->getLib()->getXML()->asXML());
    }

    protected function getLib(): Pohoda\Supplier
    {
        $lib = new Pohoda\Supplier(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        return $lib->setData([
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'B04',
                ],
            ],
            'suppliers' => [
                [
                    'supplierItem' => [
                        'default' => true,
                        'refAd' => [
                            'id' => 2,
                        ],
                        'orderCode' => 'A1',
                        'orderName' => 'A-zasoba',
                        'purchasingPrice' => 1968,
                        'rate' => 0,
                        'payVAT' => false,
                        'ean' => '11112228',
                        'printEAN' => true,
                        'unitEAN' => 'ks',
                        'unitCoefEAN' => 1,
                        'deliveryTime' => 12,
                        'minQuantity' => 2,
                        'note' => 'fdf',
                    ],
                ],
                [
                    'supplierItem' => [
                        'default' => false,
                        'refAd' => [
                            'ids' => 'INTEAK spol. s r. o.',
                        ],
                        'orderCode' => 'I1',
                        'orderName' => 'I-zasoba',
                        'purchasingPrice' => 500,
                        'rate' => 0,
                        'payVAT' => false,
                        'ean' => '212121212',
                        'printEAN' => true,
                        'unitEAN' => 'ks',
                        'unitCoefEAN' => 1,
                        'deliveryTime' => 12,
                        'minQuantity' => 2,
                        'note' => 'aasn',
                    ],
                ],
            ],
        ]);
    }
}
