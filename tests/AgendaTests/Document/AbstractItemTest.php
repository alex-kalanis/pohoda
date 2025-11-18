<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;
use kalanis\Pohoda\Type;

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
        $homeCurr = new Type\Dtos\CurrencyItemDto();
        $homeCurr->unitPrice = 198;

        $foreignCurr = new Type\Dtos\CurrencyItemDto();
        $foreignCurr->unitPrice = 7591;

        $stock = new Type\Dtos\StockItemDto();
        $stock->stockItem = [
            'stockItem' => [
                'ids' => 'STM',
            ],
        ];

        $dto = new XDocumentItemDto();
        $dto->homeCurrency = $homeCurr;
        $dto->foreignCurrency = $foreignCurr;
        $dto->stockItem = $stock;

        $lib = new XDocumentItem($this->getBasicDi());
        $lib->setData($dto);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEmpty($lib->getXML());
    }
}
