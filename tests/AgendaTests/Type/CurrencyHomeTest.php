<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\Type\CurrencyHome;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class CurrencyHomeTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib(false);
        $this->assertInstanceOf(CurrencyHome::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertNull($lib->getImportRoot());
    }

    protected function getLib(bool $resolve = true): CurrencyHome
    {
        return new CurrencyHome(
            new Pohoda\Common\NamespacesPaths(),
            new SanitizeEncoding(new Listing()),
            '123',
            $resolve,
        );
    }
}
