<?php

namespace tests\BasicTests;

use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer;

class XParameter
{
    use AddParameterTrait;

    public array $data = [];
    protected string $companyRegistrationNumber = 'dummy';
    protected readonly NamespacesPaths $namespacesPaths;
    protected readonly ValueTransformer\SanitizeEncoding $sanitizeEncoding;

    public function __construct()
    {
        $this->namespacesPaths = new NamespacesPaths();
        $this->sanitizeEncoding = new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing());
    }
}
