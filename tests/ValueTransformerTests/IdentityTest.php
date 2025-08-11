<?php

namespace tests\ValueTransformerTests;

use tests\CommonTestClass;
use Riesenia\Pohoda\ValueTransformer\IdentityTransformer;

class IdentityTest extends CommonTestClass
{
    /**
     * @param string $from
     * @param string $to
     * @return void
     * @dataProvider dataProvider
     */
    public function testOk(string $from, string $to): void
    {
        $lib = new IdentityTransformer();
        $this->assertEquals($to, $lib->transform($from));
    }

    public static function dataProvider(): array
    {
        return [
            ['simple without cyrillic', 'simple without cyrillic'],
        ];
    }
}
