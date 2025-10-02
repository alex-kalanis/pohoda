<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda\Type\Address;

class AddressTest extends CommonTestClass
{
    public function testUpdateParams(): void
    {
        $lib = new Address($this->getBasicDi());
        $lib->setData([
            'shipToAddress' => [
                'name' => 'example',
            ],
        ]);
        $lib->setNamespace('lst');
        $lib->setNodeName('bar');
        $this->assertEquals('', $lib->getXML());
    }
}
