<?php

namespace BasicTests;


use CommonTestClass;
use Riesenia\Pohoda\Common\AddActionTypeTrait;
use OutOfRangeException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class ActionTypeTraitTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new XActionType();
        $lib->addActionType('add');
        $this->assertTrue(isset($lib->data['actionType']));
    }

    public function testRepeat(): void
    {
        $lib = new XActionType();
        $this->assertNotEmpty($lib->addActionType('add'));
        $this->expectException(OutOfRangeException::class);
        $lib->addActionType('delete');
    }
}


class XActionType
{
    use AddActionTypeTrait;

    public array $data = [];
    protected string $companyRegistrationNumber = 'dummy';
    protected readonly NamespacesPaths $namespacesPaths;
    protected readonly SanitizeEncoding $sanitizeEncoding;

    public function __construct()
    {
        $this->namespacesPaths = new NamespacesPaths();
        $this->sanitizeEncoding = new SanitizeEncoding(new Listing());
    }
}
