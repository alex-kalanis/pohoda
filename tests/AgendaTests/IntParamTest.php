<?php

namespace AgendaTests;

use CommonTestClass;
use Riesenia\Pohoda;


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
        $lib = new Pohoda\IntParam(new Pohoda\Common\NamespacesPaths(), [
            'name' => 'NAME',
            'parameterType' => 'listValue',
        ], '123');

        $this->assertEquals('<ipm:intParamDetail version="2.0"><ipm:intParam><ipm:name>NAME</ipm:name><ipm:parameterType>textValue</ipm:parameterType><ipm:parameterSettings><ipm:length>40</ipm:length></ipm:parameterSettings></ipm:intParam></ipm:intParamDetail>', $this->getLib()->getXML()->asXML());
    }

    protected function getLib(): Pohoda\IntParam
    {
        return new Pohoda\IntParam(new Pohoda\Common\NamespacesPaths(), [
            'name' => 'NAME',
            'parameterType' => 'textValue',
            'parameterSettings' => ['length' => 40]
        ], '123');
    }
}
