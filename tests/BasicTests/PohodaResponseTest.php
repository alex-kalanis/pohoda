<?php

namespace tests\BasicTests;

use tests\CommonTestClass;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Stock;
use Riesenia\Pohoda\ValueTransformer;
use Riesenia\PohodaResponse;

class PohodaResponseTest extends CommonTestClass
{
    protected ValueTransformer\SanitizeEncoding $sanitization;
    protected ?string $tempFile = null;

    protected function setUp(): void
    {
        $this->sanitization = new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing());
    }

    protected function tearDown(): void
    {
        if ($this->tempFile) {
            @unlink($this->tempFile);
        }
    }

    public function testWriteFile(): void
    {
        $this->tempFile = \tempnam(\sys_get_temp_dir(), 'xml');

        $data = [
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1],
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        $this->assertTrue($lib->open($this->tempFile, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, [], 'test');
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
        $data = [
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1],
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, [], 'test');

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
        $data = [
            'code' => 'code1',
            'name' => 'name2',
            'storage' => 'storage3',
            'typePrice' => ['id' => 4],
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        // set for each run
        $lib->getTransformerListing()->clear();
        $lib->getTransformerListing()->addTransformer(new XCapitalize());

        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('item_id', $stock, [], 'test');

        $xml = \simplexml_load_string($lib->close());

        $this->assertEquals('CODE1', strval($xml->xpath('//stk:code')[0]));
        $this->assertEquals('NAME2', strval($xml->xpath('//stk:name')[0]));
        $this->assertEquals('STORAGE3', strval($xml->xpath('//typ:ids')[0]));

        // Don't add transformers to other tests
        $lib->getTransformerListing()->clear();
    }

    public function testHandleSanitizeCorrectly(): void
    {
        $data = [
            'code' => 'code1',
            'name' => 'name2',
            'storage' => 'storage3',
            'typePrice' => ['id' => 4],
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $this->sanitization->willBeSanitized(true);

        $lib = $this->getLib();
        $this->assertTrue($lib->open(null, 'ABC', '', 'ok', 'test-123', '999-888-777-666-555-444-333-222-111'));
        $lib->addItem('item_id', $stock, [], 'test');
        $this->assertEquals(0, \count($this->sanitization->getListing()->clear()->getTransformers()));
        $lib->close();
    }

    public function getLib(): PohodaResponse
    {
        return new PohodaResponse(
            '123',
            $this->sanitization,
        );
    }
}
