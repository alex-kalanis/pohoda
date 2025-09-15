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
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Storage;
use Riesenia\Pohoda\ValueTransformer;


class StorageSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $this->setData([
            'code' => 'MAIN'
        ]);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\Storage');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"/></str:storage>');
    }

    public function it_can_add_substorages(): void
    {
        $sub = new Storage(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $sub->setData([
            'code' => 'Sub',
            'name' => 'Sub'
        ]);

        $this->addSubstorage($sub);

        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"/></str:subStorages></str:itemStorage></str:storage>');

        $subsub = new Storage(new NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), '123');
        $subsub->setData([
            'code' => 'SubSub',
            'name' => 'SubSub'
        ]);

        $sub->addSubstorage($subsub);

        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"><str:subStorages><str:itemStorage code="SubSub" name="SubSub"/></str:subStorages></str:itemStorage></str:subStorages></str:itemStorage></str:storage>');
    }
}
