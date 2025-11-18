<?php

namespace tests\AttributesTests\Normalizer;

use kalanis\Pohoda\AbstractAgenda;

class CallbacksTest extends AbstractNormalizerTestClass
{
    public function testValues1(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'callback1' => 'ok',
                'callback2' => 'ok',
                'callback3' => 'ok',
            ]);
        $this->assertEquals('123456', $resolved['callback1']);
        $this->assertEquals('', $resolved['callback2']);
        $this->assertEquals('1', $resolved['callback3']);
    }

    public function testValues2(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
                'callback2' => '',
                'callback3' => '0',
                'callback4' => 'foo',
            ]);
        $this->assertFalse(isset($resolved['callback1']));
        $this->assertEquals('', $resolved['callback2']);
        $this->assertEquals('0', $resolved['callback3']);
        $this->assertEquals('', $resolved['callback4']);
    }

    public function testValues3(): void
    {
        $resolved = $this->getResolver(true, false)
            ->resolve([
            ]);
        $this->assertEquals('123456', $resolved['callback5']('x'));
        $this->assertEquals('', $resolved['callback6']('x'));
        $this->assertEquals('1', $resolved['callback7']('x'));
        $this->assertEquals('0', $resolved['callback7'](''));
    }

    protected function getAgenda(): AbstractAgenda
    {
        return new XCallbackAgenda($this->getBasicDi());
    }
}
