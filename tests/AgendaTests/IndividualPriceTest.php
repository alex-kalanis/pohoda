<?php

namespace AgendaTests;


use CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;


class IndividualPriceTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\IndividualPrice::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:individualPrice', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->getXML();
    }

    protected function getLib(): Pohoda\IndividualPrice
    {
        return new Pohoda\IndividualPrice(
            new Pohoda\Common\NamespacesPaths(),
            new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()),
            [],
            '123'
        );
    }
}
