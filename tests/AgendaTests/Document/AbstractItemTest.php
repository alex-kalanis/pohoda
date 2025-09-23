<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class AbstractItemTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentItem(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentItem(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testInitParamsRun(): void
    {
        $data = [
            'homeCurrency' => [
                'unitPrice' => 198,
            ],
            'foreignCurrency' => [
                'unitPrice' => 7591,
            ],
            'stockItem' => [
                'stockItem' => [
                    'ids' => 'STM',
                ],
            ],
        ];
        $lib = new XDocumentItem(new NamespacesPaths(), new SanitizeEncoding(new Listing()));
        $lib->setData($data);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEmpty($lib->getXML());
    }
}
