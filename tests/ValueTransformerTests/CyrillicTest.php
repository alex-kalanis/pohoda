<?php

namespace ValueTransformerTests;


use CommonTestClass;
use Riesenia\Pohoda\ValueTransformer\CyrillicTransliterationTransformer;


class CyrillicTest extends CommonTestClass
{
    /**
     * @param string $from
     * @param string $to
     * @return void
     * @dataProvider dataProvider
     */
    public function testOk(string $from, string $to): void
    {
        $lib = new CyrillicTransliterationTransformer();
        $this->assertEquals($to, $lib->transform($from));
    }

    public static function dataProvider(): array
    {
        return [
            ['simple without cyrillic', 'simple without cyrillic', ],
            [transliterator_transliterate('Russian-Latin/BGN', 'Симеон Борисов Сакскобургготски'), 'Simeon Borisov Sakskoburggot·ski', ],
        ];
    }
}
