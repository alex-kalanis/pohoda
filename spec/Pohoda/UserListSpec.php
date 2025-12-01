<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class UserListSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $list = new Pohoda\UserList\UserListDto();
        $list->code = 'CODE';
        $list->name = 'NAME';

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($list);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType(Pohoda\UserList::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $code = new Pohoda\UserList\ItemUserCodeDto();
        $code->code = 'CODE 2';
        $code->name = 'NAME 2';

        $this->addItemUserCode($code);

        $this->getXML()->asXML()->shouldReturn('<lst:listUserCode version="1.1" code="CODE" name="NAME"><lst:itemUserCode code="CODE 2" name="NAME 2"/></lst:listUserCode>');
    }
}
