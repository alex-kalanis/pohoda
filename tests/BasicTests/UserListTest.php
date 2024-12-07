<?php

namespace BasicTests;

use CommonTestClass;
use Riesenia\Pohoda;

class UserListTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\UserList::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:listUserCode', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $lib->addItemUserCode([
            'code' => 'CODE 2',
            'name' => 'NAME 2',
        ]);
        $this->assertEquals('<lst:listUserCode version="1.1" code="CODE" name="NAME"><lst:itemUserCode code="CODE 2" name="NAME 2"/></lst:listUserCode>', $lib->getXML()->asXML());
    }

    public function testCreateSecondaryXml(): void
    {
        $lib = new Pohoda\UserList([
            'code' => 'CODE',
            'name' => 'NAME',
            'dateTimeStamp' => new \DateTime('2015-04-17 22:41:07'),
            'dateValidFrom' => new \DateTime('2015-04-17 22:41:07'),
            'submenu' => 'false',
            'constants' => 'true',
        ], '123');
        $lib->addItemUserCode([
            'code' => 'CODE 2',
            'name' => 'NAME 2',
            'constant' => 3,
        ]);
        $this->assertEquals('<lst:listUserCode version="1.1" code="CODE" name="NAME" dateTimeStamp="2015-04-17T22:41:07" dateValidFrom="2015-04-17" submenu="false" constants="true"><lst:itemUserCode code="CODE 2" name="NAME 2" constant="3"/></lst:listUserCode>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\UserList
    {
        return new Pohoda\UserList([
            'code' => 'CODE',
            'name' => 'NAME',
        ], '123');
    }
}
