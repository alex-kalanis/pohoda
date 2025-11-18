<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class ReceiptSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->id = 20;

        $header = new Pohoda\Receipt\HeaderDto();
        $header->date = new \DateTimeImmutable('2015-01-10');
        $header->dateOfReceipt = '';
        $header->text = 'Prijemka';
        $header->activity = [
            'id' => 1,
        ];
        $header->intNote = 'Note';
        $header->partnerIdentity = $partner;

        $dto = new Pohoda\Receipt\ReceiptDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\Receipt');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '</pri:prijemkaHeader></pri:prijemka>');
    }

    public function it_can_add_items(): void
    {
        $stock1 = new Pohoda\Type\Dtos\StockItemDto();
        $stock1->stockItem = [
            'ids' => 'model',
            'store' => 'X',
        ];

        $item1 = new Pohoda\Receipt\ItemDto();
        $item1->quantity = 2;
        $item1->stockItem = $stock1;

        $stock2 = new Pohoda\Type\Dtos\StockItemDto();
        $stock2->stockItem = [
            'ids' => 'STM',
        ];

        $item2 = new Pohoda\Receipt\ItemDto();
        $item2->quantity = 1;
        $item2->note = 'STM';
        $item2->stockItem = $stock2;

        $this->addItem($item1);
        $this->addItem($item2);

        $this->getXML()->asXML()->shouldReturn('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '</pri:prijemkaHeader><pri:prijemkaDetail><pri:prijemkaItem><pri:quantity>2</pri:quantity><pri:stockItem><typ:stockItem><typ:ids>model</typ:ids><typ:store>X</typ:store></typ:stockItem></pri:stockItem></pri:prijemkaItem><pri:prijemkaItem><pri:quantity>1</pri:quantity><pri:stockItem><typ:stockItem><typ:ids>STM</typ:ids></typ:stockItem></pri:stockItem><pri:note>STM</pri:note></pri:prijemkaItem></pri:prijemkaDetail></pri:prijemka>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<pri:prijemka version="2.0"><pri:prijemkaHeader>' . $this->defaultHeader() . '<pri:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></pri:parameters></pri:prijemkaHeader></pri:prijemka>');
    }

    protected function defaultHeader(): string
    {
        return '<pri:date>2015-01-10</pri:date><pri:dateOfReceipt/><pri:text>Prijemka</pri:text><pri:partnerIdentity><typ:id>20</typ:id></pri:partnerIdentity><pri:activity><typ:id>1</typ:id></pri:activity><pri:intNote>Note</pri:intNote>';
    }
}
