<?php

namespace tests\BasicTests;

use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ValueTransformer;

class XParameter
{
    use AddParameterTrait;

    public array $data = [];
    protected string $companyRegistrationNumber = 'dummy';
    protected readonly NamespacesPaths $namespacesPaths;
    protected readonly ValueTransformer\SanitizeEncoding $sanitizeEncoding;
    protected bool $resolveOptions = false;
    protected readonly OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory;

    public function __construct()
    {
        $this->namespacesPaths = new NamespacesPaths();
        $this->sanitizeEncoding = new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing());
        $this->normalizerFactory = new OptionsResolver\Normalizers\NormalizerFactory();
    }
}
