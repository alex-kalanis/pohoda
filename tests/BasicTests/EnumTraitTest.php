<?php

namespace tests\BasicTests;

use tests\CommonTestClass;

class EnumTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $this->assertEquals('x', XEnum::A->value);
        $this->assertEquals('y', XEnum::B->currentValue());
        $this->assertEquals(['A', 'B', 'C', ], XEnum::names());
        $this->assertEquals(['x', 'y', 'z', ], XEnum::values());
        $this->assertEquals(['A' => 'x', 'B' => 'y', 'C' => 'z', ], XEnum::array());
    }
}
