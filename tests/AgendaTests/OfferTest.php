<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class OfferTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Offer::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:offer', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader></ofr:offer>', $this->getLib()->getXML()->asXML());
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
                'priceSum' => 580,
            ],
        ]);

        $this->assertEquals('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader><ofr:offerSummary><ofr:roundingDocument>math2one</ofr:roundingDocument><ofr:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></ofr:foreignCurrency></ofr:offerSummary></ofr:offer>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
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

        $this->assertEquals('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader><ofr:offerDetail><ofr:offerItem><ofr:text>NAME 1</ofr:text><ofr:quantity>1</ofr:quantity><ofr:rateVAT>high</ofr:rateVAT><ofr:homeCurrency><typ:unitPrice>200</typ:unitPrice></ofr:homeCurrency></ofr:offerItem><ofr:offerItem><ofr:quantity>1</ofr:quantity><ofr:payVAT>true</ofr:payVAT><ofr:rateVAT>high</ofr:rateVAT><ofr:homeCurrency><typ:unitPrice>198</typ:unitPrice></ofr:homeCurrency><ofr:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></ofr:stockItem></ofr:offerItem></ofr:offerDetail></ofr:offer>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '<ofr:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></ofr:parameters></ofr:offerHeader></ofr:offer>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<ofr:offerType>receivedOffer</ofr:offerType><ofr:date>2015-01-10</ofr:date><ofr:partnerIdentity><typ:id>25</typ:id></ofr:partnerIdentity><ofr:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></ofr:myIdentity><ofr:intNote>Note</ofr:intNote>';
    }

    protected function getLib(): Pohoda\Offer
    {
        $lib = new Pohoda\Offer(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        return $lib->setData([
            'partnerIdentity' => [
                'id' => 25,
            ],
            'myIdentity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123',
                ],
            ],
            'date' => '2015-01-10',
            'intNote' => 'Note',
        ]);
    }
}
