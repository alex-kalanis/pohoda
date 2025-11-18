<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

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
        $subDto = new Pohoda\Category\CategoryDto();
        $subDto->name = 'Sub';
        $subDto->sequence = 1;
        $subDto->displayed = true;
        $sub = new Pohoda\Category($this->getBasicDi());
        $sub->setData($subDto);

        $subSubDto = new Pohoda\Category\CategoryDto();
        $subSubDto->name = 'SubSub';
        $subSubDto->sequence = 1;
        $subSubDto->displayed = false;
        $subSub = new Pohoda\Category($this->getBasicDi());
        $subSub->setData($subSubDto);

        $sub->addSubcategory($subSub);

        $sub2Dto = new Pohoda\Category\CategoryDto();
        $sub2Dto->name = 'Sub2';
        $sub2Dto->sequence = '2';
        $sub2Dto->displayed = true;
        $sub2 = new Pohoda\Category($this->getBasicDi());
        $sub2->setData($sub2Dto);

        $lib = $this->getLib();
        $lib->addSubcategory($sub);
        $lib->addSubcategory($sub2);

        $this->assertEquals('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>Sub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>SubSub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>false</ctg:displayed></ctg:category></ctg:subCategories></ctg:category><ctg:category><ctg:name>Sub2</ctg:name><ctg:sequence>2</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:subCategories></ctg:category></ctg:categoryDetail>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\Category
    {
        $dto = new Pohoda\Category\CategoryDto();
        $dto->name = 'Main';
        $dto->sequence = 1;
        $dto->displayed = true;

        $lib = new Pohoda\Category($this->getBasicDi());
        return $lib->setData($dto);
    }
}
