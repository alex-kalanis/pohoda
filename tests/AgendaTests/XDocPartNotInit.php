<?php

namespace tests\AgendaTests;

use kalanis\Pohoda;

class XDocPartNotInit extends Pohoda\Document\AbstractPart
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
    }

    protected function getDefaultDto(): Pohoda\Common\Dtos\AbstractDto
    {
        return new Pohoda\Common\Dtos\EmptyDto();
    }
}
