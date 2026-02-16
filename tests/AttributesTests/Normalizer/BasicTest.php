<?php

namespace tests\AttributesTests\Normalizer;

use kalanis\Pohoda\Common;
use Symfony\Component\OptionsResolver;

class BasicTest extends AbstractNormalizerTestClass
{
    public function testSuccessBasic(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve(Common\Dtos\Processing::filterUnusableData([
                'integer' => 123456,
                'shortString' => '',
                'longString' => null, // out!
                'requiredInteger' => 369258,
                'requiredBoolean' => false,
                'someArray' => [], // out!
                'referenceAsArray' => ['123'],
            ]));

        $this->assertEquals('low', $resolved['listOfOptionsWithDefault']);
        $this->assertEquals('123456', $resolved['integer']);
        $this->assertEquals('', $resolved['shortString']); // not wrong!
        $this->assertFalse(isset($resolved['longString']));
        $this->assertEquals('369258', $resolved['requiredInteger']);
        $this->assertEquals('false', $resolved['requiredBoolean']);
        $this->assertFalse(isset($resolved['someArray']));
        $this->assertEquals(['123'], $resolved['referenceAsArray']);
    }

    // time to fails!
    public function testFailNotAllRequiredValues(): void
    {
        $this->expectException(OptionsResolver\Exception\MissingOptionsException::class);
        $this->getResolver(false, false)
            ->resolve([
                //'requiredInteger' => '369258', // INTENTIONALLY NOT SET!
                'requiredBoolean' => 'false',
            ]);
    }
}
