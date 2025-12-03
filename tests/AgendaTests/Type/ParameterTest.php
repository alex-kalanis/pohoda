<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use kalanis\Pohoda;
use kalanis\Pohoda\Type;
use kalanis\Pohoda\ValueTransformer;

class ParameterTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $lib->setResolveOptions(false);
        $this->assertInstanceOf(Type\Parameter::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertNull($lib->getImportRoot());
    }

    public function testCreateCorrectXml1(): void
    {
        $dto = new Type\Dtos\ParameterDto();
        $dto->name = 'VPr_testing';
        $dto->type = Type\Enums\ParameterTypeEnum::Text;
        $dto->value = 'foo_bar_baz';

        $this->assertEquals(
            '<typ:parameter><typ:name>VPr_testing</typ:name><typ:textValue>foo_bar_baz</typ:textValue></typ:parameter>',
            $this->getLib()->setData($dto)->getXML()->asXML(),
        );
    }

    public function testCreateCorrectXml2(): void
    {
        $dto = new Type\Dtos\ParameterDto();
        $dto->name = 'testing';
        $dto->type = Type\Enums\ParameterTypeEnum::List;
        $dto->value = '456';
        $dto->list = [
            'statementNumber',
            'numberMovement',
        ];

        $this->assertEquals(
            '<typ:parameter><typ:name>RefVPrtesting</typ:name><typ:listValueRef><typ:ids>456</typ:ids></typ:listValueRef><typ:list><typ:0>statementNumber</typ:0><typ:1>numberMovement</typ:1></typ:list></typ:parameter>',
            $this->getLib()->setData($dto)->getXML()->asXML(),
        );
    }

    public function testCreateCorrectXml3(): void
    {
        $dto = new Type\Dtos\ParameterDto();
        $dto->name = 'testing';
        $dto->type = 'list';
        $dto->value = '456';
        $dto->list = [
            '123',
            '456',
            '789',
        ];

        $sanitize = new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing());
        $sanitize->willBeSanitized(true);
        $lib = new Type\Parameter(new Pohoda\DI\DependenciesFactory(
            new Pohoda\Common\NamespacesPaths(),
            $sanitize,
            null,
            new Pohoda\PrintRequest\ParameterInstances(),
        ));
        $lib->setData($dto);
        $this->assertEquals('<typ:parameter><typ:name>RefVPrtesting</typ:name><typ:listValueRef><typ:ids>456</typ:ids></typ:listValueRef><typ:list><typ:0>123</typ:0><typ:1>456</typ:1><typ:2>789</typ:2></typ:list></typ:parameter>', $lib->getXML()->asXML());
    }

    public function testParamDateTime(): void
    {
        $dto = new Type\Dtos\ParameterDto();
        $dto->name = 'bar';
        $dto->type = Type\Enums\ParameterTypeEnum::DateTime;
        $dto->value = '2024-05-25';

        $lib = $this->getLib()->setData($dto);
        $this->assertEquals('', $lib->getXML());
    }

    protected function getLib(): Type\Parameter
    {
        return new Type\Parameter($this->getBasicDi());
    }
}
