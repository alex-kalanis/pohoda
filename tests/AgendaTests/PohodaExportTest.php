<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

class PohodaExportTest extends CommonTestClass
{
    protected ?string $testFile = null;

    protected function setUp(): void
    {
        $this->testFile = \tempnam(\sys_get_temp_dir(), 'xml');
    }

    protected function tearDown(): void
    {
        if (is_file($this->testFile)) {
            unlink($this->testFile);
        }
    }

    public function testRecursiveExport(): void
    {
        \file_put_contents($this->testFile, '<?xml version="1.0" encoding="Windows-1250"?>
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

        $lib = new Pohoda('123', $this->getBasicDi());
        $this->assertNotEmpty($lib->loadCategory($this->testFile));

        // read only root elements
        $c = $lib->next();
        $this->assertInstanceOf(\SimpleXMLElement::class, $c);
        $this->assertEquals('Kategorie-A', $c->children('ctg', true)->name);
        $c = $lib->next();
        $this->assertInstanceOf(\SimpleXMLElement::class, $c);
        $this->assertEquals('Kategorie-D', $c->children('ctg', true)->name);
        $c = $lib->next();
        $this->assertNull($c);
    }
}
