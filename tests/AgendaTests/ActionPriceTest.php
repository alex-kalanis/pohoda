<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class ActionPriceTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\ActionPrice::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:actionPrice', $lib->getImportRoot());
        $lib->setData([]);
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getXML();
    }

    protected function getLib(): Pohoda\ActionPrice
    {
        return new Pohoda\ActionPrice(
            new Pohoda\Common\NamespacesPaths(),
            new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing()),
            '123',
        );
    }
}
