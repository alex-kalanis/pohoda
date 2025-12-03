<?php

namespace tests\BasicTests;

use kalanis\Pohoda\Common\Enums;

enum XEnum: string implements Enums\EnhancedEnumInterface
{
    use Enums\EnumTrait;

    case A = 'x';
    case B = 'y';
    case C = 'z';
}
