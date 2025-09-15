<?php

namespace tests\AgendaTests\Type;

use Riesenia\Pohoda\PrintRequest;

class XParamFactory extends PrintRequest\ParameterFactory
{
    protected array $instances = [
        'just_standard' => \stdClass::class,
        'not_instance' => XFailClass::class,
    ];
}
