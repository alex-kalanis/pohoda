<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class IssueSlipSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $address = new Pohoda\Type\Dtos\AddressTypeDto();
        $address->name = 'NAME';
        $address->ico = '123';

        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->address = $address;

        $header = new Pohoda\IssueSlip\HeaderDto();
        $header->date = '2015-01-10';
        $header->dateOrder = '2015-01-04';
        $header->text = 'Vyd';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;

        $dto = new Pohoda\IssueSlip\IssueSlipDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType(Pohoda\IssueSlip::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader></vyd:vydejka>');
    }

    public function it_can_add_items(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\IssueSlip\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->rateVAT = 'high';
        $item1->homeCurrency = $home1;

        $home2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home2->unitPrice = 198;

        $stock = new Pohoda\Type\Dtos\StockItemDto();
        $stock->stockItem = [
            'ids' => 'STM',
        ];

        $item2 = new Pohoda\IssueSlip\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:vydejkaDetail><vyd:vydejkaItem><vyd:text>NAME 1</vyd:text><vyd:quantity>1</vyd:quantity><vyd:rateVAT>high</vyd:rateVAT><vyd:homeCurrency><typ:unitPrice>200</typ:unitPrice></vyd:homeCurrency></vyd:vydejkaItem><vyd:vydejkaItem><vyd:quantity>1</vyd:quantity><vyd:payVAT>true</vyd:payVAT><vyd:rateVAT>high</vyd:rateVAT><vyd:homeCurrency><typ:unitPrice>198</typ:unitPrice></vyd:homeCurrency><vyd:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></vyd:stockItem></vyd:vydejkaItem></vyd:vydejkaDetail></vyd:vydejka>');
    }

    public function it_can_set_summary(): void
    {
        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\IssueSlip\SummaryDto();
        $summary->roundingDocument = 'math2one';
        $summary->foreignCurrency = $foreign;

        $this->addSummary($summary);

        $this->getXML()->asXML()->shouldReturn('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:vydejkaSummary><vyd:roundingDocument>math2one</vyd:roundingDocument><vyd:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></vyd:foreignCurrency></vyd:vydejkaSummary></vyd:vydejka>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '<vyd:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></vyd:parameters></vyd:vydejkaHeader></vyd:vydejka>');
    }

    public function it_can_link_to_order(): void
    {
        $link = new Pohoda\Type\Dtos\LinkDto();
        $link->sourceAgenda = 'receivedOrder';
        $link->sourceDocument = [
            'number' => '142100003',
        ];

        $this->addLink($link);

        $this->getXML()->asXML()->shouldReturn('<vyd:vydejka version="2.0"><vyd:vydejkaHeader>' . $this->defaultHeader() . '</vyd:vydejkaHeader><vyd:links><typ:link><typ:sourceAgenda>receivedOrder</typ:sourceAgenda><typ:sourceDocument><typ:number>142100003</typ:number></typ:sourceDocument></typ:link></vyd:links></vyd:vydejka>');
    }

    protected function defaultHeader(): string
    {
        return '<vyd:date>2015-01-10</vyd:date><vyd:dateOrder>2015-01-04</vyd:dateOrder><vyd:text>Vyd</vyd:text><vyd:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></vyd:partnerIdentity><vyd:intNote>Note</vyd:intNote>';
    }
}
