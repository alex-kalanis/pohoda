<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda\Type\MyAddress;

class MyAddressTest extends CommonTestClass
{
    public function testUpdateParams(): void
    {
        $lib = new MyAddress($this->getBasicDi());
        $lib->setData([
            'establishment' => [
                'company' => 'example',
            ],
        ]);
        $lib->setNamespace('lst');
        $lib->setNodeName('bar');
        $this->assertEquals('', $lib->getXML());
    }
}
