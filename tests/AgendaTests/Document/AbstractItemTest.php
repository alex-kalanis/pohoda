<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;

class AbstractItemTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentItem($this->getBasicDi());
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentItem($this->getBasicDi());
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
        $lib = new XDocumentItem($this->getBasicDi());
        $lib->setData($data);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEmpty($lib->getXML());
    }
}
