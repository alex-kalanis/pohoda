<?php

namespace tests\BasicTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Stock;
use Riesenia\Pohoda\ValueTransformer;

class PohodaTest extends CommonTestClass
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

    public function testCanInit(): void
    {
        $lib = $this->getLib();
        $lib->setApplicationName('testing one');
        $this->assertInstanceOf(Pohoda::class, $lib);
    }

    public function testThrowsExceptionOnWrongAgendaName(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->create('*');
    }

    public function testCreateExistingObject(): void
    {
        $lib = $this->getLib();
        $result = $lib->create('Stock', [
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1]
        ]);
        $this->assertInstanceOf(Pohoda\Stock::class, $result);
    }

    public function testSomeCreateByMethod(): void
    {
        $lib = $this->getLib();
        $result = $lib->createStock([
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1]
        ]);
        $this->assertInstanceOf(Pohoda\Stock::class, $result);
    }

    public function testFailedDynamicLoad(): void
    {
        $lib = $this->getLib();
        $this->expectException(\DomainException::class);
        $lib->loadVoucher(); // intentionally empty
    }

    public function testBadCall(): void
    {
        $lib = $this->getLib();
        $this->expectException(\BadMethodCallException::class);
        $lib->deleteVoucher(); // this method does not exist
    }

    public function testWriteFile(): void
    {
        $this->tempFile = \tempnam(\sys_get_temp_dir(), 'xml');

        $data = [
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1]
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        $this->assertTrue($lib->open($this->tempFile, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, $data);
        $lib->close();

        $xml = \simplexml_load_file($this->tempFile);

        // test dataPack properties
        $this->assertEquals('ABC', strval($xml['id']));
        $this->assertEquals('123', strval($xml['ico']));
        $this->assertEquals('', strval($xml['note']));

        // test dataPackItem properties
        $this->assertEquals('ITEM_ID', strval($xml->children('dat', true)->dataPackItem->attributes()['id']));
    }

    public function testNoFile(): void
    {
        $lib = $this->getLib();
        $this->assertFalse($lib->load('ABC', 'file://this_file_does_not_exists'));
    }

/*
    public function testNoString(): void
    {
        $lib = $this->getLib();
        $this->assertFalse($lib->load('Category', 'this is not valid <?xml string!'));
    }
*/

    public function testCanWriteToMemory(): void
    {
        $data = [
            'code' => 'CODE',
            'name' => 'NAME',
            'storage' => 'STORAGE',
            'typePrice' => ['id' => 1]
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('ITEM_ID', $stock, $data);

        $xml = \simplexml_load_string($lib->close());

        // test dataPack properties
        $this->assertEquals('ABC', strval($xml['id']));
        $this->assertEquals('123', strval($xml['ico']));
        $this->assertEquals('', strval($xml['note']));

        // test dataPackItem properties
        $this->assertEquals('ITEM_ID', strval($xml->children('dat', true)->dataPackItem->attributes()['id']));
    }

    public function testProcessesRecursiveExportCorrectlyFile(): void
    {
        $this->tempFile = \tempnam(\sys_get_temp_dir(), 'xml');

        \file_put_contents($this->tempFile, '<?xml version="1.0" encoding="Windows-1250"?>
        <rsp:responsePack version="2.0" id="002" state="ok" note="" xmlns:rsp="http://www.stormware.cz/schema/version_2/response.xsd" xmlns:lst="http://www.stormware.cz/schema/version_2/list.xsd" xmlns:ctg="http://www.stormware.cz/schema/version_2/category.xsd">
            <rsp:responsePackItem version="2.0" id="a56" state="ok">
                <lst:listCategory version="2.0" state="ok">
                    <lst:categoryDetail version="2.0">
                        <ctg:category>
                            <ctg:id>1</ctg:id>
                            <ctg:name>Kategorie-A</ctg:name>
                            <ctg:description/>
                            <ctg:sequence>0</ctg:sequence>
                            <ctg:displayed>true</ctg:displayed>
                            <ctg:picture/>
                            <ctg:note/>
                            <ctg:internetParams>
                                <ctg:idInternetParams>3</ctg:idInternetParams>
                            </ctg:internetParams>
                            <ctg:subCategories>
                                <ctg:category>
                                    <ctg:id>2</ctg:id>
                                    <ctg:name>Kategorie-B</ctg:name>
                                    <ctg:description>testovaci kategorie B</ctg:description>
                                    <ctg:sequence>1</ctg:sequence>
                                    <ctg:displayed>true</ctg:displayed>
                                    <ctg:picture/>
                                    <ctg:note/>
                                    <ctg:internetParams>
                                        <ctg:idInternetParams>1</ctg:idInternetParams>
                                    </ctg:internetParams>
                                </ctg:category>
                                <ctg:category>
                                    <ctg:id>3</ctg:id>
                                    <ctg:name>Kategorie-C</ctg:name>
                                    <ctg:description>testovaci kategorie C</ctg:description>
                                    <ctg:sequence>2</ctg:sequence>
                                    <ctg:displayed>true</ctg:displayed>
                                    <ctg:picture/>
                                    <ctg:note/>
                                    <ctg:internetParams>
                                        <ctg:idInternetParams>2</ctg:idInternetParams>
                                    </ctg:internetParams>
                                </ctg:category>
                            </ctg:subCategories>
                        </ctg:category>
                        <ctg:category>
                            <ctg:id>4</ctg:id>
                            <ctg:name>Kategorie-D</ctg:name>
                            <ctg:description>testovaci kategorie D</ctg:description>
                            <ctg:sequence>0</ctg:sequence>
                            <ctg:displayed>true</ctg:displayed>
                            <ctg:picture/>
                            <ctg:note/>
                            <ctg:internetParams>
                                <ctg:idInternetParams/>
                            </ctg:internetParams>
                        </ctg:category>
                    </lst:categoryDetail>
                </lst:listCategory>
            </rsp:responsePackItem>
        </rsp:responsePack>');

        $lib = $this->getLib();
        $this->assertNotEmpty($lib->loadCategory($this->tempFile));

        // read only root elements
        $this->assertEquals('Kategorie-A', strval($lib->next()->children('ctg', true)->name));
        $this->assertEquals('Kategorie-D', strval($lib->next()->children('ctg', true)->name));
        $this->assertNull($lib->next());
    }

    public function testProcessesRecursiveExportCorrectlyString(): void
    {
        $data = '<?xml version="1.0" encoding="Windows-1250"?>
        <rsp:responsePack version="2.0" id="002" state="ok" note="" xmlns:rsp="http://www.stormware.cz/schema/version_2/response.xsd" xmlns:lst="http://www.stormware.cz/schema/version_2/list.xsd" xmlns:ctg="http://www.stormware.cz/schema/version_2/category.xsd">
            <rsp:responsePackItem version="2.0" id="a56" state="ok">
                <lst:listCategory version="2.0" state="ok">
                    <lst:categoryDetail version="2.0">
                        <ctg:category>
                            <ctg:id>1</ctg:id>
                            <ctg:name>Kategorie-A</ctg:name>
                            <ctg:description/>
                            <ctg:sequence>0</ctg:sequence>
                            <ctg:displayed>true</ctg:displayed>
                            <ctg:picture/>
                            <ctg:note/>
                            <ctg:internetParams>
                                <ctg:idInternetParams>3</ctg:idInternetParams>
                            </ctg:internetParams>
                            <ctg:subCategories>
                                <ctg:category>
                                    <ctg:id>2</ctg:id>
                                    <ctg:name>Kategorie-B</ctg:name>
                                    <ctg:description>testovaci kategorie B</ctg:description>
                                    <ctg:sequence>1</ctg:sequence>
                                    <ctg:displayed>true</ctg:displayed>
                                    <ctg:picture/>
                                    <ctg:note/>
                                    <ctg:internetParams>
                                        <ctg:idInternetParams>1</ctg:idInternetParams>
                                    </ctg:internetParams>
                                </ctg:category>
                                <ctg:category>
                                    <ctg:id>3</ctg:id>
                                    <ctg:name>Kategorie-C</ctg:name>
                                    <ctg:description>testovaci kategorie C</ctg:description>
                                    <ctg:sequence>2</ctg:sequence>
                                    <ctg:displayed>true</ctg:displayed>
                                    <ctg:picture/>
                                    <ctg:note/>
                                    <ctg:internetParams>
                                        <ctg:idInternetParams>2</ctg:idInternetParams>
                                    </ctg:internetParams>
                                </ctg:category>
                            </ctg:subCategories>
                        </ctg:category>
                        <ctg:category>
                            <ctg:id>4</ctg:id>
                            <ctg:name>Kategorie-D</ctg:name>
                            <ctg:description>testovaci kategorie D</ctg:description>
                            <ctg:sequence>0</ctg:sequence>
                            <ctg:displayed>true</ctg:displayed>
                            <ctg:picture/>
                            <ctg:note/>
                            <ctg:internetParams>
                                <ctg:idInternetParams/>
                            </ctg:internetParams>
                        </ctg:category>
                    </lst:categoryDetail>
                </lst:listCategory>
            </rsp:responsePackItem>
        </rsp:responsePack>';

        $lib = $this->getLib();
        $this->assertNotEmpty($lib->loadCategory($data));

        // read only root elements
        $this->assertEquals('Kategorie-A', strval($lib->next()->children('ctg', true)->name));
        $this->assertEquals('Kategorie-D', strval($lib->next()->children('ctg', true)->name));
        $this->assertNull($lib->next());
    }

    public function testRunTransformersProperly(): void
    {
        $data = [
            'code' => 'code1',
            'name' => 'name2',
            'storage' => 'storage3',
            'typePrice' => ['id' => 4]
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $lib = $this->getLib();
        // set for each run
        $lib->getTransformerListing()->clear();
        $lib->getTransformerListing()->addTransformer(new XCapitalize());

        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('item_id', $stock, $data);

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
            'typePrice' => ['id' => 4]
        ];
        $stock = new Stock(new NamespacesPaths(), $this->sanitization, '123');
        $stock->setData($data);

        $this->sanitization->willBeSanitized(true);

        $lib = $this->getLib();
        $this->assertTrue($lib->open(null, 'ABC'));
        $lib->addItem('item_id', $stock, $data);
        $this->assertEquals(0, \count($this->sanitization->getListing()->clear()->getTransformers()));
        $lib->close();
    }

    public function getLib(): Pohoda
    {
        return new Pohoda(
            '123', $this->sanitization,
        );
    }
}
