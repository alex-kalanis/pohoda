<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class AddressBookSpec extends ObjectBehavior
{
    use DiTrait;

    public function constructSelf(): void
    {
        $addrType = new Pohoda\Type\Dtos\AddressTypeDto();
        $addrType->name = 'NAME';
        $addrType->ico = '123';

        $addr = new Pohoda\Type\Dtos\AddressDto();
        $addr->address = $addrType;

        $header = new Pohoda\AddressBook\HeaderDto();
        $header->phone = '123';
        $header->centre = ['id' => 1];
        $header->identity = $addr;

        $dto = new Pohoda\AddressBook\AddressBookDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->constructSelf();
        $this->shouldHaveType('kalanis\Pohoda\AddressBook');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->constructSelf();
        $this->getXML()->asXML()->shouldReturn('<adb:addressbook version="2.0"><adb:addressbookHeader>' . $this->defaultHeader() . '</adb:addressbookHeader></adb:addressbook>');
    }

    public function it_can_set_action_type(): void
    {
        $this->constructSelf();
        $this->addActionType('update', [
            'company' => 'COMPANY',
        ]);

        $this->getXML()->asXML()->shouldReturn('<adb:addressbook version="2.0"><adb:actionType><adb:update><ftr:filter><ftr:company>COMPANY</ftr:company></ftr:filter></adb:update></adb:actionType><adb:addressbookHeader>' . $this->defaultHeader() . '</adb:addressbookHeader></adb:addressbook>');
    }

    public function it_can_set_parameters(): void
    {
        $this->constructSelf();
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<adb:addressbook version="2.0"><adb:addressbookHeader>' . $this->defaultHeader() . '<adb:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></adb:parameters></adb:addressbookHeader></adb:addressbook>');
    }

    public function it_can_delete_address(): void
    {
        $this->beConstructedWith($this->getBasicDi());

        $this->addActionType('delete', [
            'company' => 'COMPANY',
        ]);

        $this->getXML()->asXML()->shouldReturn('<adb:addressbook version="2.0"><adb:actionType><adb:delete><ftr:filter><ftr:company>COMPANY</ftr:company></ftr:filter></adb:delete></adb:actionType></adb:addressbook>');
    }

    public function it_leaves_special_characters_intact_by_default(): void
    {
        $addrType = new Pohoda\Type\Dtos\AddressTypeDto();
        $addrType->name = 'Călărași ñüé¿s';
        $addrType->city = 'Dâmbovița';

        $addr = new Pohoda\Type\Dtos\AddressDto();
        $addr->address = $addrType;

        $header = new Pohoda\AddressBook\HeaderDto();
        $header->phone = '123';
        $header->centre = ['id' => 1];
        $header->identity = $addr;

        $dto = new Pohoda\AddressBook\AddressBookDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);

        $this->getXML()->asXML()->shouldReturn('<adb:addressbook version="2.0"><adb:addressbookHeader><adb:identity><typ:address><typ:name>Călărași ñüé¿s</typ:name><typ:city>Dâmbovița</typ:city></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre></adb:addressbookHeader></adb:addressbook>');
    }

    protected function defaultHeader(): string
    {
        return '<adb:identity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre>';
    }
}
