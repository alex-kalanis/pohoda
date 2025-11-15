<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda\Type;

class AddressTest extends CommonTestClass
{
    public function testUpdateParams(): void
    {
        $shipTo = new Type\Dtos\ShipToAddressDto();
        $shipTo->name = 'example';
        $dto = new Type\Dtos\AddressDto();
        $dto->shipToAddress = $shipTo;

        $lib = new Type\Address($this->getBasicDi());
        $lib->setData($dto);
        $lib->setNamespace('lst');
        $lib->setNodeName('bar');
        $this->assertEquals('', $lib->getXML());
    }
}
