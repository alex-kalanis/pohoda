<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use Riesenia\Pohoda\Type;

class MyAddressTest extends CommonTestClass
{
    public function testUpdateParams(): void
    {
        $establishment = new Type\Dtos\EstablishmentTypeDto();
        $establishment->company = 'example';

        $dto = new Type\Dtos\MyAddressDto();
        $dto->establishment = $establishment;

        $lib = new Type\MyAddress($this->getBasicDi());
        $lib->setData($dto);
        $lib->setNamespace('lst');
        $lib->setNodeName('bar');
        $this->assertEquals('', $lib->getXML());
    }
}
