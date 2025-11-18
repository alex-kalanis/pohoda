<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use kalanis\Pohoda;
use kalanis\Pohoda\Type\CurrencyHome;

class CurrencyHomeTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $lib->setResolveOptions(false);
        $this->assertInstanceOf(CurrencyHome::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertNull($lib->getImportRoot());
    }

    protected function getLib(): CurrencyHome
    {
        return new CurrencyHome($this->getBasicDi());
    }
}
