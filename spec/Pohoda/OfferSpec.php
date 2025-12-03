<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class OfferSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $myAddress = new Pohoda\Type\Dtos\AddressInternetTypeDto();
        $myAddress->name = 'NAME';
        $myAddress->ico = '123';

        $myIdentity = new Pohoda\Type\Dtos\MyAddressDto();
        $myIdentity->address = $myAddress;

        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 25;

        $header = new Pohoda\Offer\HeaderDto();
        $header->date = '2015-01-10';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;
        $header->myIdentity = $myIdentity;

        $dto = new Pohoda\Offer\OfferDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType(Pohoda\Offer::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader></ofr:offer>');
    }

    public function it_can_add_items(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\Offer\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->rateVAT = Pohoda\Common\Enums\RateVatHistoryEnum::High;
        $item1->homeCurrency = $home1;

        $home2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home2->unitPrice = 198;

        $stock2 = new Pohoda\Type\Dtos\StockItemDto();
        $stock2->stockItem = [
            'ids' => 'STM',
        ];

        $item2 = new Pohoda\Offer\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock2;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader><ofr:offerDetail><ofr:offerItem><ofr:text>NAME 1</ofr:text><ofr:quantity>1</ofr:quantity><ofr:rateVAT>high</ofr:rateVAT><ofr:homeCurrency><typ:unitPrice>200</typ:unitPrice></ofr:homeCurrency></ofr:offerItem><ofr:offerItem><ofr:quantity>1</ofr:quantity><ofr:payVAT>true</ofr:payVAT><ofr:rateVAT>high</ofr:rateVAT><ofr:homeCurrency><typ:unitPrice>198</typ:unitPrice></ofr:homeCurrency><ofr:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></ofr:stockItem></ofr:offerItem></ofr:offerDetail></ofr:offer>');
    }

    public function it_can_set_summary(): void
    {
        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\Offer\SummaryDto();
        $summary->roundingDocument = Pohoda\Common\Enums\RoundingDocumentEnum::Math2one;
        $summary->foreignCurrency = $foreign;

        $this->addSummary($summary);

        $this->getXML()->asXML()->shouldReturn('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '</ofr:offerHeader><ofr:offerSummary><ofr:roundingDocument>math2one</ofr:roundingDocument><ofr:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></ofr:foreignCurrency></ofr:offerSummary></ofr:offer>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<ofr:offer version="2.0"><ofr:offerHeader>' . $this->defaultHeader() . '<ofr:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></ofr:parameters></ofr:offerHeader></ofr:offer>');
    }

    protected function defaultHeader(): string
    {
        return '<ofr:offerType>receivedOffer</ofr:offerType><ofr:date>2015-01-10</ofr:date><ofr:partnerIdentity><typ:id>25</typ:id></ofr:partnerIdentity><ofr:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></ofr:myIdentity><ofr:intNote>Note</ofr:intNote>';
    }
}
