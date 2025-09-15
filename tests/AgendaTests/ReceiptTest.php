<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class ReceiptTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Receipt::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:prijemka', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '</pri:prijemkaHeader></pri:prijemka>', $this->getLib()->getXML()->asXML());
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

        $this->assertEquals('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '</pri:prijemkaHeader><pri:prijemkaSummary><pri:roundingDocument>math2one</pri:roundingDocument><pri:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></pri:foreignCurrency></pri:prijemkaSummary></pri:prijemka>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
    {
        $lib = $this->getLib();
        $lib->addItem([
            'quantity' => 2,
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'model',
                    'store' => 'X'
                ]
            ]
        ]);

        $lib->addItem([
            'quantity' => 1,
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'STM'
                ]
            ],
            'note' => 'STM'
        ]);

        $this->assertEquals('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '</pri:prijemkaHeader><pri:prijemkaDetail><pri:prijemkaItem><pri:quantity>2</pri:quantity><pri:stockItem><typ:stockItem><typ:ids>model</typ:ids><typ:store>X</typ:store></typ:stockItem></pri:stockItem></pri:prijemkaItem><pri:prijemkaItem><pri:quantity>1</pri:quantity><pri:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pri:stockItem><pri:note>STM</pri:note></pri:prijemkaItem></pri:prijemkaDetail></pri:prijemka>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '<pri:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pri:parameters></pri:prijemkaHeader></pri:prijemka>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<pri:date>2015-01-10</pri:date><pri:dateOfReceipt/><pri:text>Prijemka</pri:text><pri:partnerIdentity><typ:id>20</typ:id></pri:partnerIdentity><pri:activity><typ:id>1</typ:id></pri:activity><pri:intNote>Note</pri:intNote>';
    }

    protected function getLib(): Pohoda\Receipt
    {
        $lib = new Pohoda\Receipt(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        return $lib->setData([
            'date' => new \DateTimeImmutable('2015-01-10'),
            'dateOfReceipt' => '',
            'text' => 'Prijemka',
            'partnerIdentity' => [
                'id' => 20
            ],
            'activity' => [
                'id' => 1,
            ],
            'intNote' => 'Note'
        ]);
    }
}
