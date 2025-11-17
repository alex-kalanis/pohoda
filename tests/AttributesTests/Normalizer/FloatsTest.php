<?php

namespace tests\AttributesTests\Normalizer;

class FloatsTest extends AbstractNormalizerTestClass
{
    public function testValues(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'float' => '1 234,56',
                'responseFloat' => null,
            ]);
        $this->assertEquals('1234.56', $resolved['float']);
        $this->assertEquals('', $resolved['responseFloat']);
    }
}
