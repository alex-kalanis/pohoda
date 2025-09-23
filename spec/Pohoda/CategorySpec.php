<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia\Pohoda;

use PhpSpec\ObjectBehavior;
use Riesenia\Pohoda\Category;
use Riesenia\Pohoda\Common\CompanyRegistrationNumber;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer;

class CategorySpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), CompanyRegistrationNumber::init('123'));
        $this->setData([
            'name' => 'Main',
            'sequence' => 1,
            'displayed' => true,
        ]);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\Category');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:categoryDetail>');
    }

    public function it_can_add_subcategories(): void
    {
        $sub = new Category(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), CompanyRegistrationNumber::init('123'));
        $sub->setData([
            'name' => 'Sub',
            'sequence' => 1,
            'displayed' => true,
        ]);

        $subsub = new Category(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), CompanyRegistrationNumber::init('123'));
        $subsub->setData([
            'name' => 'SubSub',
            'sequence' => 1,
            'displayed' => false,
        ]);

        $sub->addSubcategory($subsub);

        $sub2 = new Category(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), CompanyRegistrationNumber::init('123'));
        $sub2->setData([
            'name' => 'Sub2',
            'sequence' => '2',
            'displayed' => true,
        ]);

        $this->addSubcategory($sub);
        $this->addSubcategory($sub2);

        $this->getXML()->asXML()->shouldReturn('<ctg:categoryDetail version="2.0"><ctg:category><ctg:name>Main</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>Sub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>true</ctg:displayed><ctg:subCategories><ctg:category><ctg:name>SubSub</ctg:name><ctg:sequence>1</ctg:sequence><ctg:displayed>false</ctg:displayed></ctg:category></ctg:subCategories></ctg:category><ctg:category><ctg:name>Sub2</ctg:name><ctg:sequence>2</ctg:sequence><ctg:displayed>true</ctg:displayed></ctg:category></ctg:subCategories></ctg:category></ctg:categoryDetail>');
    }
}
