<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

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
        $code = new Pohoda\UserList\ItemUserCodeDto();
        $code->code = 'CODE 2';
        $code->name = 'NAME 2';
        $lib = $this->getLib();
        $lib->addItemUserCode($code);
        $this->assertEquals('<lst:listUserCode version="1.1" code="CODE" name="NAME"><lst:itemUserCode code="CODE 2" name="NAME 2"/></lst:listUserCode>', $lib->getXML()->asXML());
    }

    public function testCreateSecondaryXml(): void
    {
        $list = new Pohoda\UserList\UserListDto();
        $list->code = 'CODE';
        $list->name = 'NAME';
        $list->dateTimeStamp = new \DateTime('2015-04-17 22:41:07');
        $list->dateValidFrom = new \DateTime('2015-04-17 22:41:07');
        $list->submenu = 'false';
        $list->constants = 'true';

        $code = new Pohoda\UserList\ItemUserCodeDto();
        $code->code = 'CODE 2';
        $code->name = 'NAME 2';
        $code->constant = 3;

        $lib = new Pohoda\UserList($this->getBasicDi());
        $lib->setData($list);
        $lib->addItemUserCode($code);
        $this->assertEquals('<lst:listUserCode version="1.1" code="CODE" name="NAME" dateTimeStamp="2015-04-17T22:41:07" dateValidFrom="2015-04-17" submenu="false" constants="true"><lst:itemUserCode code="CODE 2" name="NAME 2" constant="3"/></lst:listUserCode>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\UserList
    {
        $list = new Pohoda\UserList\UserListDto();
        $list->code = 'CODE';
        $list->name = 'NAME';

        $lib = new Pohoda\UserList($this->getBasicDi());
        return $lib->setData($list);
    }
}
