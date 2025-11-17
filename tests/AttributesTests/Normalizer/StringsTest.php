<?php

namespace tests\AttributesTests\Normalizer;

class StringsTest extends AbstractNormalizerTestClass
{
    public function testCutStringTooLong(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'shortString' => 'foo-bar-baz-foo-bar-baz', // This is too long
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
            ]);
        $this->assertEquals('foo-bar-ba', $resolved['shortString']);
    }
}
