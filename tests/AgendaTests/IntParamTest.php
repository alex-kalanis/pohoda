<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

class IntParamTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\IntParam::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:intParamDetail', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<ipm:intParamDetail version="2.0"><ipm:intParam><ipm:name>NAME</ipm:name><ipm:parameterType>textValue</ipm:parameterType><ipm:parameterSettings><ipm:length>40</ipm:length></ipm:parameterSettings></ipm:intParam></ipm:intParamDetail>', $this->getLib()->getXML()->asXML());
    }

    public function testCreateList(): void
    {
        $paramsSett = new Pohoda\IntParam\SettingsDto();
        $paramsSett->length = 40;

        $dto = new Pohoda\IntParam\IntParamDto();
        $dto->name = 'NAME';
        $dto->parameterType = 'listValue';
        $dto->parameterSettings = $paramsSett;

        $lib = new Pohoda\IntParam($this->getBasicDi());
        $lib->setData($dto);

        $this->assertEquals('<ipm:intParamDetail version="2.0"><ipm:intParam><ipm:name>NAME</ipm:name><ipm:parameterType>textValue</ipm:parameterType><ipm:parameterSettings><ipm:length>40</ipm:length></ipm:parameterSettings></ipm:intParam></ipm:intParamDetail>', $this->getLib()->getXML()->asXML());
    }

    protected function getLib(): Pohoda\IntParam
    {
        $paramsSett = new Pohoda\IntParam\SettingsDto();
        $paramsSett->length = 40;

        $dto = new Pohoda\IntParam\IntParamDto();
        $dto->name = 'NAME';
        $dto->parameterType = Pohoda\Common\Enums\ParamTypeEnum::TextValue;
        $dto->parameterSettings = $paramsSett;

        $lib = new Pohoda\IntParam($this->getBasicDi());
        return $lib->setData($dto);
    }
}
