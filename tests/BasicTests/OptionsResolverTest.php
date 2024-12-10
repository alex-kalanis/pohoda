<?php

namespace BasicTests;

use CommonTestClass;
use DomainException;
use Riesenia\Pohoda\Common\OptionsResolver;


class OptionsResolverTest extends CommonTestClass
{
    public function testBasicString(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('string');
        $this->assertEquals('this is some string', $closure1(null, 'this is some string'));

        $closure2 = $lib->getNormalizer('str');
        $this->assertEquals('this is another string', $closure2(null, 'this is another string'));
    }

    public function testLimitString(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('string16');
        $this->assertEquals('this is some str', $closure1(null, 'this is some string'));

        $closure2 = $lib->getNormalizer('str16');
        $this->assertEquals('this is another ', $closure2(null, 'this is another string'));

        $closure3 = $lib->getNormalizer('?string16');
        $this->assertEquals('this is some str', $closure3(null, 'this is some string'));

        $closure4 = $lib->getNormalizer('?str16');
        $this->assertEquals('this is another ', $closure4(null, 'this is another string'));
    }

    public function testInteger(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('int');
        $this->assertEquals('123456', $closure1(null, '123 456.789'));
        $this->assertEquals('0', $closure1(null, '0'));
        $this->assertEquals('0', $closure1(null, ''));

        $closure2 = $lib->getNormalizer('?int');
        $this->assertEquals('123456', $closure2(null, '123 456.789'));
        $this->assertEquals('0', $closure2(null, '0'));
        $this->assertEquals('', $closure2(null, ''));
    }

    public function testFloat(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('number');
        $this->assertEquals('123456.789', $closure1(null, '123 456.789'));
        $this->assertEquals('0', $closure1(null, '0'));
        $this->assertEquals('0', $closure1(null, ''));

        $closure2 = $lib->getNormalizer('?float');
        $this->assertEquals('123456.789', $closure2(null, '123 456.789'));
        $this->assertEquals('0', $closure2(null, '0'));
        $this->assertEquals('', $closure2(null, ''));
    }

    public function testBool(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('bool');
        $this->assertEquals('true', $closure1(null, 'true'));
        $this->assertEquals('true', $closure1(null, true));
        $this->assertEquals('true', $closure1(null, 'boo'));
        $this->assertEquals('false', $closure1(null, false));
        $this->assertEquals('false', $closure1(null, null));
        $this->assertEquals('false', $closure1(null, ''));
        $this->assertSame($closure1, $lib->getNormalizer('bool'));

        $closure2 = $lib->getNormalizer('?bool');
        $this->assertEquals('true', $closure2(null, 'true'));
        $this->assertEquals('true', $closure2(null, true));
        $this->assertEquals('true', $closure2(null, 'boo'));
        $this->assertEquals('false', $closure2(null, false));
        $this->assertEquals('', $closure2(null, null));
        $this->assertEquals('', $closure2(null, ''));
    }

    public function testDate(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('?date');
        $this->assertEquals('', $closure1(null, '')); // empty
        $this->assertEquals('', $closure1(null, null)); // empty
        $this->assertEquals('2020-08-28', $closure1(null, new \DateTime('2020-08-28 17:17')));
        $this->assertEquals('2020-08-28', $closure1(null, '2020-08-28 17:17'));
    }

    public function testDateTime(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('?datetime');
        $this->assertEquals('', $closure1(null, '')); // empty
        $this->assertEquals('', $closure1(null, null)); // empty
        $this->assertEquals('2020-08-28T17:17:00', $closure1(null, new \DateTime('2020-08-28 17:17')));
        $this->assertEquals('2020-08-28T17:17:00', $closure1(null, '2020-08-28 17:17'));
    }

    public function testTime(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('?time');
        $this->assertEquals('', $closure1(null, '')); // empty
        $this->assertEquals('', $closure1(null, null)); // empty
        $this->assertEquals('17:17:00', $closure1(null, new \DateTime('2020-08-28 17:17')));
        $this->assertEquals('17:17:00', $closure1(null, '2020-08-28 17:17'));
    }

    public function testDateTimeFail(): void
    {
        $lib = new OptionsResolver();
        $closure1 = $lib->getNormalizer('time');
        $this->expectException(DomainException::class);
        $closure1(null, ''); // pass empty and it will die
    }

    public function testInvalidType(): void
    {
        $lib = new OptionsResolver();
        $this->expectException(DomainException::class);
        $lib->getNormalizer('unknown_one');
    }
}
