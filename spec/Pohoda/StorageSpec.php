<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use PhpSpec\ObjectBehavior;
use kalanis\Pohoda\Storage;
use spec\kalanis\DiTrait;

class StorageSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $store = new Storage\StorageDto();
        $store->code = 'MAIN';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($store);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\Storage');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"/></str:storage>');
    }

    public function it_can_add_substorages(): void
    {
        $subStore = new Storage\StorageDto();
        $subStore->code = 'Sub';
        $subStore->name = 'Sub';

        $sub = new Storage($this->getBasicDi());
        $sub->setData($subStore);

        $this->addSubstorage($sub);

        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"/></str:subStorages></str:itemStorage></str:storage>');

        $subSubStore = new Storage\StorageDto();
        $subSubStore->code = 'SubSub';
        $subSubStore->name = 'SubSub';

        $subsub = new Storage($this->getBasicDi());
        $subsub->setData($subSubStore);

        $sub->addSubStorage($subsub);

        $this->getXML()->asXML()->shouldReturn('<str:storage version="2.0"><str:itemStorage code="MAIN"><str:subStorages><str:itemStorage code="Sub" name="Sub"><str:subStorages><str:itemStorage code="SubSub" name="SubSub"/></str:subStorages></str:itemStorage></str:subStorages></str:itemStorage></str:storage>');
    }
}
