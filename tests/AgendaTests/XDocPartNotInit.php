<?php

namespace tests\AgendaTests;

use Riesenia\Pohoda;

class XDocPartNotInit extends Pohoda\Document\AbstractPart
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
    }

    protected function configureOptions(Pohoda\Common\OptionsResolver $resolver): void {}

    protected function getDefaultDto(): Pohoda\Common\Dtos\AbstractDto
    {
        return new Pohoda\Common\Dtos\EmptyDto();
    }
}
