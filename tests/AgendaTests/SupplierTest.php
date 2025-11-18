<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

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
        $supplier1 = new Pohoda\Supplier\SupplierItemDto();
        $supplier1->default = true;
        $supplier1->refAd = [
            'id' => 2,
        ];
        $supplier1->orderCode = 'A1';
        $supplier1->orderName = 'A-zasoba';
        $supplier1->purchasingPrice = 1968;
        $supplier1->rate = 0;
        $supplier1->payVAT = false;
        $supplier1->ean = '11112228';
        $supplier1->printEAN = true;
        $supplier1->unitEAN = 'ks';
        $supplier1->unitCoefEAN = 1;
        $supplier1->deliveryTime = 12;
        $supplier1->minQuantity = 2;
        $supplier1->note = 'fdf';

        $supplier2 = new Pohoda\Supplier\SupplierItemDto();
        $supplier2->default = false;
        $supplier2->refAd = [
            'ids' => 'INTEAK spol. s r. o.',
        ];
        $supplier2->orderCode = 'I1';
        $supplier2->orderName = 'I-zasoba';
        $supplier2->purchasingPrice = 500;
        $supplier2->rate = 0;
        $supplier2->payVAT = false;
        $supplier2->ean = '212121212';
        $supplier2->printEAN = true;
        $supplier2->unitEAN = 'ks';
        $supplier2->unitCoefEAN = 1;
        $supplier2->deliveryTime = 12;
        $supplier2->minQuantity = 2;
        $supplier2->note = 'aasn';

        $stockItem = new Pohoda\Supplier\StockItemDto();
        $stockItem->stockItem = [
            'ids' => 'B04',
        ];

        $supplier = new Pohoda\Supplier\SupplierDto();
        $supplier->stockItem = $stockItem;
        $supplier->suppliers = [
            $supplier1,
            $supplier2,
        ];

        $lib = new Pohoda\Supplier($this->getBasicDi());
        return $lib->setData($supplier);
    }
}
