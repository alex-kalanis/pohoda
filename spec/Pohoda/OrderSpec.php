<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class OrderSpec extends ObjectBehavior
{
    use DiTrait;

    public function constructSelf(): void
    {
        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 25;

        $mineAddr = new Pohoda\Type\Dtos\AddressInternetTypeDto();
        $mineAddr->name = 'NAME';
        $mineAddr->ico = '123';

        $mine = new Pohoda\Type\Dtos\MyAddressDto();
        $mine->address = $mineAddr;

        $header = new Pohoda\Order\HeaderDto();
        $header->date = '2015-01-10';
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;
        $header->myIdentity = $mine;

        $dto = new Pohoda\Order\OrderDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->constructSelf();
        $this->shouldHaveType(Pohoda\Order::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $this->constructSelf();
        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader></ord:order>');
    }

    public function it_can_set_action_type(): void
    {
        $this->constructSelf();
        $this->addActionType('update', [
            'numberOrder' => '222',
        ]);

        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:actionType><ord:update><ftr:filter><ftr:numberOrder>222</ftr:numberOrder></ftr:filter></ord:update></ord:actionType></ord:order>');
    }

    public function it_can_add_items(): void
    {
        $this->constructSelf();

        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 200;

        $item1 = new Pohoda\Order\ItemDto();
        $item1->text = 'NAME 1';
        $item1->quantity = 1;
        $item1->delivered = 0;
        $item1->rateVAT = 'high';
        $item1->homeCurrency = $home1;

        $home2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home2->unitPrice = 198;

        $stock = new Pohoda\Type\Dtos\StockItemDto();
        $stock->stockItem = [
            'ids' => 'STM',
        ];
        $stock->insertAttachStock = false;
        $stock->applyUserSettingsFilterOnTheStore = false;

        $item2 = new Pohoda\Order\ItemDto();
        $item2->quantity = 1;
        $item2->payVAT = true;
        $item2->rateVAT = 'high';
        $item2->homeCurrency = $home2;
        $item2->stockItem = $stock;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderDetail><ord:orderItem><ord:text>NAME 1</ord:text><ord:quantity>1</ord:quantity><ord:delivered>0</ord:delivered><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>200</typ:unitPrice></ord:homeCurrency></ord:orderItem><ord:orderItem><ord:quantity>1</ord:quantity><ord:payVAT>true</ord:payVAT><ord:rateVAT>high</ord:rateVAT><ord:homeCurrency><typ:unitPrice>198</typ:unitPrice></ord:homeCurrency><ord:stockItem><typ:stockItem insertAttachStock="false" applyUserSettingsFilterOnTheStore="false"><typ:ids>STM</typ:ids></typ:stockItem></ord:stockItem></ord:orderItem></ord:orderDetail></ord:order>');
    }

    public function it_can_set_summary(): void
    {
        $this->constructSelf();

        $foreign = new Pohoda\Type\Dtos\CurrencyForeignDto();
        $foreign->currency = 'EUR';
        $foreign->rate = '20.232';
        $foreign->amount = 1;
        $foreign->priceSum = 580;

        $summary = new Pohoda\Order\SummaryDto();
        $summary->roundingDocument = 'math2one';
        $summary->foreignCurrency = $foreign;

        $this->addSummary($summary);

        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '</ord:orderHeader><ord:orderSummary><ord:roundingDocument>math2one</ord:roundingDocument><ord:foreignCurrency><typ:currency><typ:ids>EUR</typ:ids></typ:currency><typ:rate>20.232</typ:rate><typ:amount>1</typ:amount><typ:priceSum>580</typ:priceSum></ord:foreignCurrency></ord:orderSummary></ord:order>');
    }

    public function it_can_set_parameters(): void
    {
        $this->constructSelf();
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:orderHeader>' . $this->defaultHeader() . '<ord:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></ord:parameters></ord:orderHeader></ord:order>');
    }

    public function it_can_delete_order(): void
    {
        $this->beConstructedWith($this->getBasicDi());

        $this->addActionType('delete', [
            'number' => '222',
        ], 'prijate_objednavky');

        $this->getXML()->asXML()->shouldReturn('<ord:order version="2.0"><ord:actionType><ord:delete><ftr:filter agenda="prijate_objednavky"><ftr:number>222</ftr:number></ftr:filter></ord:delete></ord:actionType></ord:order>');
    }

    protected function defaultHeader(): string
    {
        return '<ord:orderType>receivedOrder</ord:orderType><ord:date>2015-01-10</ord:date><ord:partnerIdentity><typ:id>25</typ:id></ord:partnerIdentity><ord:myIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></ord:myIdentity><ord:intNote>Note</ord:intNote>';
    }
}
