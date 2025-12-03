<?php

namespace tests\AttributesTests\Normalizer;

use kalanis\Pohoda\Common;

class FactoryTest extends AbstractNormalizerTestClass
{
    /**
     * @param string $type
     * @param class-string $desired
     * @throws \kalanis\PohodaException
     * @return void
     * @dataProvider instancesProvider
     */
    public function testInstances(string $type, string $desired): void
    {
        $this->assertInstanceOf($desired, Common\OptionsResolver\Normalizers\NormalizerFactory::createNormalizer($type));
    }

    public static function instancesProvider(): array
    {
        return [
            ['string', Common\OptionsResolver\Normalizers\Strings::class],
            ['str', Common\OptionsResolver\Normalizers\Strings::class],
            ['float', Common\OptionsResolver\Normalizers\Numbers::class],
            ['number', Common\OptionsResolver\Normalizers\Numbers::class],
            ['bool', Common\OptionsResolver\Normalizers\Booleans::class],
            ['boolean', Common\OptionsResolver\Normalizers\Booleans::class],
            ['date', Common\OptionsResolver\Normalizers\Dates::class],
            ['datetime', Common\OptionsResolver\Normalizers\DateTimes::class],
            ['time', Common\OptionsResolver\Normalizers\Times::class],
            ['list_request_type', Common\OptionsResolver\Normalizers\ListRequestType::class],
        ];
    }
}
