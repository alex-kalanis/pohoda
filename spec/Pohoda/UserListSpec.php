<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use PhpSpec\ObjectBehavior;
use spec\Riesenia\DiTrait;

class UserListSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $this->beConstructedWith($this->getBasicDi());
        $this->setData([
            'code' => 'CODE',
            'name' => 'NAME',
        ]);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\UserList');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->addItemUserCode([
            'code' => 'CODE 2',
            'name' => 'NAME 2',
        ]);

        $this->getXML()->asXML()->shouldReturn('<lst:listUserCode version="1.1" code="CODE" name="NAME"><lst:itemUserCode code="CODE 2" name="NAME 2"/></lst:listUserCode>');
    }
}
