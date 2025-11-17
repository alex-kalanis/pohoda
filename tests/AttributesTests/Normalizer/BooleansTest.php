<?php

namespace tests\AttributesTests\Normalizer;

class BooleansTest extends AbstractNormalizerTestClass
{
    public function testValues1(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'someBoolean' => true,
            ]);
        $this->assertEquals('false', $resolved['requiredBoolean']);
        $this->assertEquals('true', $resolved['someBoolean']);
    }

    public function testValues2(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => 'false',
                'someBoolean' => 'true',
            ]);
        $this->assertEquals('false', $resolved['requiredBoolean']);
        $this->assertEquals('true', $resolved['someBoolean']);
    }

    public function testValues3Wtf(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => 'not-a-bool',
                'someBoolean' => null,
            ]);
        $this->assertEquals('true', $resolved['requiredBoolean']); // that's right - non-empty is set to true
        $this->assertEquals('', $resolved['someBoolean']); // also right - some is nullable and this is the result
    }

    public function testValues4Wtf(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'requiredInteger' => 369258,
                'requiredBoolean' => 465315313,
                'someBoolean' => '0',
            ]);
        $this->assertEquals('true', $resolved['requiredBoolean']); // that's right - non-empty data is set to true
        $this->assertEquals('', $resolved['someBoolean']); // also right - empty data - php behavior
    }
}
