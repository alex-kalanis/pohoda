<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

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
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\IssueSlip\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->rateVAT = Pohoda\Common\Enums\RateVatHistoryEnum::High;
        $item1->homeCurrency = $home1;

        $lib = $this->getLib();
        $lib->addItem($item1);

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader><int:intDocDetail><int:intDocItem><int:text>NAME 1</int:text><int:quantity>1</int:quantity><int:rateVAT>high</int:rateVAT><int:homeCurrency><typ:unitPrice>200</typ:unitPrice></int:homeCurrency></int:intDocItem></int:intDocDetail></int:intDoc>', $lib->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\IntDoc\SummaryDto();
        $summary->roundingDocument = Pohoda\Common\Enums\RoundingDocumentEnum::Math2one;
        $summary->foreignCurrency = $foreign;

        $lib = $this->getLib();
        $lib->addSummary($summary);

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader><int:intDocSummary><int:roundingDocument>math2one</int:roundingDocument><int:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></int:foreignCurrency></int:intDocSummary></int:intDoc>', $lib->getXML()->asXML());
    }

    public function testTaxDocument(): void
    {
        $sourceLiquidation = new Pohoda\Type\Dtos\SourceLiquidationDto();
        $sourceLiquidation->sourceItemId = '0123456879';

        $taxDoc = new Pohoda\Type\Dtos\TaxDocumentDto();
        $taxDoc->sourceLiquidation = $sourceLiquidation;

        $lib = $this->getLib();
        $lib->addTaxDocument($taxDoc);

        $this->assertEquals('<int:intDoc version="2.0"><int:taxDocument><int:sourceLiquidation><typ:sourceItemId>123456879</typ:sourceItemId></int:sourceLiquidation></int:taxDocument><int:intDocHeader>' . $this->defaultHeader() . '</int:intDocHeader></int:intDoc>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', Pohoda\Type\Enums\ParameterTypeEnum::Boolean, 'true');
        $lib->addParameter('VPrNum', Pohoda\Type\Enums\ParameterTypeEnum::Number, 10.43);
        $lib->addParameter('RefVPrCountry', Pohoda\Type\Enums\ParameterTypeEnum::List, 'SK', 'Country');
        $lib->addParameter('CustomList', Pohoda\Type\Enums\ParameterTypeEnum::List, ['id' => 5], ['id' => 6]);

        $this->assertEquals('<int:intDoc version="2.0"><int:intDocHeader>' . $this->defaultHeader() . '<int:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></int:parameters></int:intDocHeader></int:intDoc>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<int:date>2015-01-10</int:date><int:partnerIdentity><typ:id>25</typ:id></int:partnerIdentity><int:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></int:myIdentity><int:intNote>Note</int:intNote>';
    }

    protected function getLib(): Pohoda\IntDoc
    {
        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 25;

        $myAddr = new Pohoda\Type\Dtos\AddressInternetTypeDto();
        $myAddr->name = 'NAME';
        $myAddr->ico = '123';

        $myIdent = new Pohoda\Type\Dtos\MyAddressDto();
        $myIdent->address = $myAddr;

        $header = new Pohoda\IntDoc\HeaderDto();
        $header->partnerIdentity = $partner;
        $header->myIdentity = $myIdent;
        $header->date = '2015-01-10';
        $header->intNote = 'Note';

        $dto = new Pohoda\IntDoc\IntDocDto();
        $dto->header = $header;

        $lib = new Pohoda\IntDoc($this->getBasicDi());
        return $lib->setData($dto);
    }
}
