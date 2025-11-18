<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class CashSlipSpec extends ObjectBehavior
{
    use DiTrait;

    public function let()
    {
        $address = new Pohoda\Type\Dtos\AddressTypeDto();
        $address->name = 'NAME';
        $address->ico = '123';

        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->address = $address;

        $header = new Pohoda\CashSlip\HeaderDto();
        $header->date = '2015-01-10';
        $header->text = 'Prod';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;

        $dto = new Pohoda\CashSlip\CashSlipDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\CashSlip');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader></pro:prodejka>');
    }

    public function it_can_add_items(): void
    {
        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\CashSlip\ItemDto();
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

        $item2 = new Pohoda\CashSlip\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader><pro:prodejkaDetail><pro:prodejkaItem><pro:text>NAME 1</pro:text><pro:quantity>1</pro:quantity><pro:rateVAT>high</pro:rateVAT><pro:homeCurrency><typ:unitPrice>200</typ:unitPrice></pro:homeCurrency></pro:prodejkaItem><pro:prodejkaItem><pro:quantity>1</pro:quantity><pro:payVAT>true</pro:payVAT><pro:rateVAT>high</pro:rateVAT><pro:homeCurrency><typ:unitPrice>198</typ:unitPrice></pro:homeCurrency><pro:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pro:stockItem></pro:prodejkaItem></pro:prodejkaDetail></pro:prodejka>');
    }

    public function it_can_set_summary(): void
    {
        $home = new Pohoda\Type\Dtos\CurrencyHomeDto();
        $home->priceNone = '0.0000';
        $home->priceLow = '0.0000';
        $home->priceLowVAT = '0.0000';
        $home->priceLowVatRate = '12';
        $home->priceHigh = '156.0000';
        $home->priceHighVAT = '31.2000';
        $home->price3 = '0.0000';
        $home->price3VAT = '0.0000';
        $home->round = [
            'priceRound' => '0.0000',
        ];

        $summary = new Pohoda\CashSlip\SummaryDto();
        $summary->roundingDocument = 'math2one';
        $summary->homeCurrency = $home;

        $this->addSummary($summary);

        $this->getXML()->asXML()->shouldReturn('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '</pro:prodejkaHeader><pro:prodejkaSummary><pro:roundingDocument>math2one</pro:roundingDocument><pro:homeCurrency><typ:priceNone>0</typ:priceNone><typ:price3>0</typ:price3><typ:price3VAT>0</typ:price3VAT><typ:priceLow>0</typ:priceLow><typ:priceLowVAT rate="12">0</typ:priceLowVAT><typ:priceHigh>156</typ:priceHigh><typ:priceHighVAT>31.2</typ:priceHighVAT><typ:round><typ:priceRound>0.0000</typ:priceRound></typ:round></pro:homeCurrency></pro:prodejkaSummary></pro:prodejka>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<pro:prodejka version="2.0"><pro:prodejkaHeader>' . $this->defaultHeader() . '<pro:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pro:parameters></pro:prodejkaHeader></pro:prodejka>');
    }

    protected function defaultHeader(): string
    {
        return '<pro:prodejkaType>saleVoucher</pro:prodejkaType><pro:date>2015-01-10</pro:date><pro:text>Prod</pro:text><pro:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></pro:partnerIdentity><pro:intNote>Note</pro:intNote>';
    }
}
