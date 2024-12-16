<?php

namespace AgendaTests;


use CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;


class CategoryTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Category::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('ctg:category', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:categoryDetail>', $this->getLib()->getXML()->asXML());
    }

    public function testAddSubCategories(): void
    {
        $sub = new Pohoda\Category(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'name' => 'Sub',
            'sequence' => 1,
            'displayed' => true
        ], '123');

        $subSub = new Pohoda\Category(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'name' => 'SubSub',
            'sequence' => 1,
            'displayed' => false
        ], '123');

        $sub->addSubcategory($subSub);

        $sub2 = new Pohoda\Category(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'name' => 'Sub2',
            'sequence' => '2',
            'displayed' => true
        ], '123');

        $lib = $this->getLib();
        $lib->addSubcategory($sub);
        $lib->addSubcategory($sub2);

        $this->assertEquals('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>Sub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>SubSub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>false</ctg:displayed></ctg:category></ctg:subCategories></ctg:category><ctg:category><ctg:name>Sub2</ctg:name><ctg:sequence>2</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:subCategories></ctg:category></ctg:categoryDetail>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\Category
    {
        return new Pohoda\Category(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
            'name' => 'Main',
            'sequence' => 1,
            'displayed' => true
        ], '123');
    }
}
