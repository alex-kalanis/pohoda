<?php

namespace ValueTransformerTests;


use CommonTestClass;
use Riesenia\Pohoda\ValueTransformer\EncodingTransformer;


class EncodingTest extends CommonTestClass
{
    /**
     * @param string $encFrom
     * @param string $encTo
     * @param string $from
     * @param string $to
     * @return void
     * @dataProvider dataProvider
     */
    public function testOk(string $encFrom, string $encTo, string $from, string $to): void
    {
        $lib = new EncodingTransformer($encFrom, $encTo);
        $this->assertEquals($to, $lib->transform($from));
    }

    public static function dataProvider(): array
    {
        return [
            ['UTF-8', 'ISO-8859-1', 'simple without cyrillic', 'simple without cyrillic'],
            ['UTF-8', 'ISO-8859-1//IGNORE', 'Симеон Борисов Сакскобургготски', '  '],
            ['UTF-8', 'ISO-8859-1//IGNORE', 'Θεσσαλονίκη', ''],
        ];
    }
}
