<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class AddressBookTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\AddressBook::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lAdb:addressbook', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $this->assertEquals('<adb:addressbook version="2.0"><adb:addressbookHeader>' . $this->defaultHeader() . '</adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    public function testSetActionType(): void
    {
        $lib = $this->getLib();
        $lib->addActionType('update', [
            'company' => 'COMPANY',
        ]);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:actionType><adb:update><ftr:filter><ftr:company>COMPANY</ftr:company></ftr:filter></adb:update></adb:actionType><adb:addressbookHeader>' . $this->defaultHeader() . '</adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:addressbookHeader>' . $this->defaultHeader() . '<adb:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></adb:parameters></adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    public function testDeleteAddress(): void
    {
        $lib = new Pohoda\AddressBook(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->addActionType('delete', [
            'company' => 'COMPANY',
        ]);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:actionType><adb:delete><ftr:filter><ftr:company>COMPANY</ftr:company></ftr:filter></adb:delete></adb:actionType></adb:addressbook>', $lib->getXML()->asXML());
    }

    public function testWithSpecialCharsIntact(): void
    {
        $lib = new Pohoda\AddressBook(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $lib->setData([
            'identity' => [
                'address' => [
                    'name' => 'Călărași ñüé¿s',
                    'city' => 'Dâmbovița',
                ],
            ],
            'phone' => '123',
            'centre' => ['id' => 1],
        ]);

        $this->assertEquals('<adb:addressbook version="2.0"><adb:addressbookHeader><adb:identity><typ:address><typ:name>Călărași ñüé¿s</typ:name><typ:city>Dâmbovița</typ:city></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre></adb:addressbookHeader></adb:addressbook>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<adb:identity><typ:address><typ:name>NAME</typ:name><typ:ico>123</typ:ico></typ:address></adb:identity><adb:phone>123</adb:phone><adb:centre><typ:id>1</typ:id></adb:centre>';
    }

    protected function getLib(): Pohoda\AddressBook
    {
        $lib = new Pohoda\AddressBook(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        return $lib->setData([
            'identity' => [
                'address' => [
                    'name' => 'NAME',
                    'ico' => '123',
                ],
            ],
            'phone' => '123',
            'centre' => ['id' => 1],
        ]);
    }
}
