<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class StockTransferSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $partnerAddress = new Pohoda\Type\Dtos\AddressTypeDto();
        $partnerAddress->name = 'NAME';
        $partnerAddress->ico = '123';

        $partnerIdentity = new Pohoda\Type\Dtos\AddressDto();
        $partnerIdentity->address = $partnerAddress;

        $stockHeader = new Pohoda\StockTransfer\HeaderDto();
        $stockHeader->date = '2015-01-10';
        $stockHeader->store = [
            'ids' => 'MAIN',
        ];
        $stockHeader->text = 'Prevodka na MAIN';
        $stockHeader->activity = [
            'id' => 1,
        ];
        $stockHeader->intNote = 'Note';
        $stockHeader->partnerIdentity = $partnerIdentity;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($stockHeader);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\StockTransfer');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '</pre:prevodkaHeader></pre:prevodka>');
    }

    public function it_can_add_items(): void
    {
        $stock1 = new Pohoda\Type\Dtos\StockItemDto();
        $stock1->stockItem = [
            'ids' => 'model',
            'store' => 'X',
        ];
        $item1 = new Pohoda\StockTransfer\ItemDto();
        $item1->quantity = 2;
        $item1->stockItem = $stock1;

        $stock2 = new Pohoda\Type\Dtos\StockItemDto();
        $stock2->stockItem = [
            'ids' => 'STM',
        ];
        $item2 = new Pohoda\StockTransfer\ItemDto();
        $item2->quantity = 1;
        $item2->note = 'STM';
        $item2->stockItem = $stock2;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '</pre:prevodkaHeader><pre:prevodkaDetail><pre:prevodkaItem><pre:quantity>2</pre:quantity><pre:stockItem><typ:stockItem><typ:ids>model</typ:ids><typ:store>X</typ:store></typ:stockItem></pre:stockItem></pre:prevodkaItem><pre:prevodkaItem><pre:quantity>1</pre:quantity><pre:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pre:stockItem><pre:note>STM</pre:note></pre:prevodkaItem></pre:prevodkaDetail></pre:prevodka>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<pre:prevodka version="2.0"><pre:prevodkaHeader>' . $this->defaultHeader() . '<pre:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pre:parameters></pre:prevodkaHeader></pre:prevodka>');
    }

    protected function defaultHeader(): string
    {
        return '<pre:date>2015-01-10</pre:date><pre:store><typ:ids>MAIN</typ:ids></pre:store><pre:text>Prevodka na MAIN</pre:text><pre:partnerIdentity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></pre:partnerIdentity><pre:activity><typ:id>1</typ:id></pre:activity><pre:intNote>Note</pre:intNote>';
    }
}
