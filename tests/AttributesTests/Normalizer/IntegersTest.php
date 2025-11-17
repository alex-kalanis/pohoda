<?php

namespace tests\AttributesTests\Normalizer;

class IntegersTest extends AbstractNormalizerTestClass
{
    public function testValues(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'integer' => '123456',
                'responseInteger' => null,
            ]);
        $this->assertEquals('369258', $resolved['requiredInteger']);
        $this->assertEquals('123456', $resolved['integer']);
        $this->assertEquals('', $resolved['responseInteger']);
    }
}
