<?php

namespace tests\BasicTests;

use Riesenia\Pohoda\Common\AddActionTypeTrait;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class XActionType
{
    use AddActionTypeTrait;

    public array $data = [];
    protected string $companyRegistrationNumber = 'dummy';
    protected readonly NamespacesPaths $namespacesPaths;
    protected readonly SanitizeEncoding $sanitizeEncoding;
    protected bool $resolveOptions = false;
    protected readonly OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory;

    public function __construct()
    {
        $this->namespacesPaths = new NamespacesPaths();
        $this->sanitizeEncoding = new SanitizeEncoding(new Listing());
        $this->normalizerFactory = new OptionsResolver\Normalizers\NormalizerFactory();
    }
}
