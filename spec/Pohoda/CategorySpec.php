<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use kalanis\Pohoda\Category;
use spec\kalanis\DiTrait;

class CategorySpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $dto = new Pohoda\Category\CategoryDto();
        $dto->name = 'Main';
        $dto->sequence = 1;
        $dto->displayed = true;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType(Pohoda\Category::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:categoryDetail>');
    }

    public function it_can_add_subcategories(): void
    {
        $subDto = new Pohoda\Category\CategoryDto();
        $subDto->name = 'Sub';
        $subDto->sequence = 1;
        $subDto->displayed = true;
        $sub = new Category($this->getBasicDi());
        $sub->setData($subDto);

        $subSubDto = new Pohoda\Category\CategoryDto();
        $subSubDto->name = 'SubSub';
        $subSubDto->sequence = 1;
        $subSubDto->displayed = false;
        $subsub = new Category($this->getBasicDi());
        $subsub->setData($subSubDto);

        $sub->addSubcategory($subsub);

        $sub2Dto = new Pohoda\Category\CategoryDto();
        $sub2Dto->name = 'Sub2';
        $sub2Dto->sequence = '2';
        $sub2Dto->displayed = true;
        $sub2 = new Category($this->getBasicDi());
        $sub2->setData($sub2Dto);

        $this->addSubcategory($sub);
        $this->addSubcategory($sub2);

        $this->getXML()->asXML()->shouldReturn('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>Sub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>SubSub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>false</ctg:displayed></ctg:category></ctg:subCategories></ctg:category><ctg:category><ctg:name>Sub2</ctg:name><ctg:sequence>2</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:subCategories></ctg:category></ctg:categoryDetail>');
    }
}
