<?php

namespace tests\AttributesTests\Normalizer;

use Riesenia\Pohoda\Common;
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
            ]));

        $this->assertEquals('low', $resolved['listOfOptionsWithDefault']);
        $this->assertEquals('123456', $resolved['integer']);
        $this->assertEquals('', $resolved['shortString']); // not wrong!
        $this->assertEquals('369258', $resolved['requiredInteger']);
        $this->assertEquals('false', $resolved['requiredBoolean']);
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
