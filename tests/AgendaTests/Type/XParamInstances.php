<?php

namespace tests\AgendaTests\Type;

use kalanis\Pohoda\PrintRequest;

class XParamInstances extends PrintRequest\ParameterInstances
{
    protected array $instances = [
        'just_standard' => \stdClass::class,
        'not_instance' => XFailClass::class,
    ];
}
