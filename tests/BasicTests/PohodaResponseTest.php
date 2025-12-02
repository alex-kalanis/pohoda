<?php

namespace tests\BasicTests;

use kalanis\Pohoda;
use kalanis\PohodaResponse;
use tests\CommonTestClass;

class PohodaResponseTest extends CommonTestClass
{
    protected ?string $tempFile = null;

    protected function tearDown(): void
    {
        if ($this->tempFile) {
            @unlink($this->tempFile);
        }
    }

    public function testWriteFile(): void
    {
        $this->tempFile = \tempnam(\sys_get_temp_dir(), 'xml');

        $stockHeaderDto = new Pohoda\Stock\HeaderDto();
        $stockHeaderDto->code = 'CODE';
        $stockHeaderDto->name = 'NAME';
        $stockHeaderDto->storage = 'STORAGE';
        $stockHeaderDto->typePrice = ['id' => 1];
        $stockDto = new Pohoda\Stock\StockDto();
        $stockDto->header = $stockHeaderDto;

        $stock = new Pohoda\Stock($this->getBasicDi());
        $stock->setData($stockDto);

        $lib = $this->getLib();
        $this->assertTrue($lib->open($this->tempFile, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, 'test');
        $lib->close();

        $xml = \simplexml_load_file($this->tempFile);

        // test dataPack properties
        $this->assertEquals('ABC', strval($xml['id']));
        $this->assertEquals('123', strval($xml['ico']));
        $this->assertEquals('', strval($xml['note']));

        // test dataPackItem properties
        $this->assertEquals('ITEM_ID', strval($xml->children('rsp', true)->responsePackItem->attributes()['id']));
    }

    public function testCanWriteToMemory(): void
    {
        $stockHeaderDto = new Pohoda\Stock\HeaderDto();
        $stockHeaderDto->code = 'CODE';
        $stockHeaderDto->name = 'NAME';
        $stockHeaderDto->storage = 'STORAGE';
        $stockHeaderDto->typePrice = ['id' => 1];
        $stockDto = new Pohoda\Stock\StockDto();
        $stockDto->header = $stockHeaderDto;

        $stock = new Pohoda\Stock($this->getBasicDi());
        $stock->setData($stockDto);

        $lib = $this->getLib();
        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, 'test');

        $xml = \simplexml_load_string($lib->close());

        // test dataPack properties
        $this->assertEquals('ABC', strval($xml['id']));
        $this->assertEquals('123', strval($xml['ico']));
        $this->assertEquals('', strval($xml['note']));

        // test dataPackItem properties
        $this->assertEquals('ITEM_ID', strval($xml->children('rsp', true)->responsePackItem->attributes()['id']));
    }

    public function testRunTransformersProperly(): void
    {
        $di = $this->getBasicDi(); // MUST be connected

        $stockHeaderDto = new Pohoda\Stock\HeaderDto();
        $stockHeaderDto->code = 'code1';
        $stockHeaderDto->name = 'name2';
        $stockHeaderDto->storage = 'storage3';
        $stockHeaderDto->typePrice = ['id' => 4];
        $stockDto = new Pohoda\Stock\StockDto();
        $stockDto->header = $stockHeaderDto;

        $stock = new Pohoda\Stock($di);
        $stock->setData($stockDto);

        $lib = new PohodaResponse('123', $di);
        // set for each run
        $lib->getTransformerListing()->clear();
        $lib->getTransformerListing()->addTransformer(new XCapitalize());

        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('item_id', $stock, 'test');

        $xml = \simplexml_load_string($lib->close());

        $this->assertEquals('CODE1', strval($xml->xpath('//stk:code')[0]));
        $this->assertEquals('NAME2', strval($xml->xpath('//stk:name')[0]));
        $this->assertEquals('STORAGE3', strval($xml->xpath('//typ:ids')[0]));

        // Don't add transformers to other tests
        $lib->getTransformerListing()->clear();
    }

    public function testHandleSanitizeCorrectly(): void
    {
        $sanitization = new Pohoda\ValueTransformer\SanitizeEncoding(new Pohoda\ValueTransformer\Listing());
        $di = new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            $sanitization,
            null,
            new Pohoda\PrintRequest\ParameterInstances(),
        );

        $stockHeaderDto = new Pohoda\Stock\HeaderDto();
        $stockHeaderDto->code = 'code1';
        $stockHeaderDto->name = 'name2';
        $stockHeaderDto->storage = 'storage3';
        $stockHeaderDto->typePrice = ['id' => 4];
        $stockDto = new Pohoda\Stock\StockDto();
        $stockDto->header = $stockHeaderDto;

        $stock = new Pohoda\Stock($di);
        $stock->setData($stockDto);

        $sanitization->willBeSanitized(true);

        $lib = new PohodaResponse('123', $di);
        $this->assertTrue($lib->open(null, 'ABC', '', 'ok', 'test-123', '999-888-777-666-555-444-333-222-111'));
        $lib->addItem('item_id', $stock, 'test');
        $this->assertEquals(0, \count($sanitization->getListing()->clear()->getTransformers()));
        $lib->close();
    }

    public function getLib(): PohodaResponse
    {
        return new PohodaResponse(
            '123',
            $this->getBasicDi(),
        );
    }
}
