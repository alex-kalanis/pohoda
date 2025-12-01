<?php

namespace tests\AttributesTests\Normalizer;

use kalanis\PohodaException;

class DatesTest extends AbstractNormalizerTestClass
{
    public function testValues1(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'someDate' => date_create_immutable('2025-11-17 13:37:00'),
                'responseDate' => '2018-10-28 16:00:00',
                'responseTime' => '2018-10-28 16:30:00',
            ]);
        $this->assertEquals('2025-11-17', $resolved['someDate']);
        $this->assertEquals('2018-10-28T16:00:00', $resolved['responseDate']);
        $this->assertEquals('16:30:00', $resolved['responseTime']);
    }

    public function testValues2(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'responseDate' => null,
            ]);
        $this->assertEquals('', $resolved['responseDate']);
    }

    public function testValuesFail(): void
    {
        $this->expectException(PohodaException::class);
        $this->getResolver(true, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'someDate' => 'this is not a clock',
            ]);
    }
}
