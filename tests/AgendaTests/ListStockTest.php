<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class ListStockTest extends CommonTestClass
{

    public function testSimple(): void
    {
        $lib = new Pohoda\ListStock(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Stock',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ], '123');
        $this->assertEquals('<lStk:listStock version="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"/>', $lib->getXML()->asXML());
//        $this->assertEquals(, $lib->getXML()->asXML());
    }

    public function testAddressBook(): void
    {
        $lib = new Pohoda\ListStock(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'AddressBook',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ], '123');
        $this->assertEquals('<lAdb:listAddressBook version="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"/>', $lib->getXML()->asXML());
    }

    public function testStock(): void
    {
        $lib = new Pohoda\ListStock(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'type' => 'Other',
            'timestamp' => date_create_immutable('2025-07-01T01:00:00'),
            'validFrom' => date_create_immutable('2025-07-01'),
            'state' => 'ok',
        ], '123');
        $this->assertEquals('<lst:listOther version="2.0" dateTimeStamp="2025-07-01T01:00:00" dateValidFrom="2025-07-01" state="ok"/>', $lib->getXML()->asXML());
    }
}
