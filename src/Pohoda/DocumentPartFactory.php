<?php

namespace Riesenia\Pohoda;

use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class DocumentPartFactory
{
    public function __construct(
        protected readonly Common\NamespacesPaths $namespacesPaths,
        protected readonly SanitizeEncoding $sanitizeEncoding,
        protected readonly Common\CompanyRegistrationNumberInterface $companyNumber,
        protected readonly Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    ) {}

    /**
     * @param string $parentClass
     * @param string $name
     * @param bool $resolveOptions
     * @throws DomainException
     * @return Document\AbstractPart
     */
    public function getPart(string $parentClass, string $name, bool $resolveOptions = true): Document\AbstractPart
    {
        /** @var class-string<Document\AbstractPart> $className */
        $className = $parentClass . '\\' . $name;
        try {
            $reflection = new ReflectionClass($className);
        } catch (ReflectionException) {
            throw new DomainException('Entity does not exists: ' . $name);
        }

        if (!$reflection->isInstantiable()) {
            throw new DomainException('Entity cannot be initialized: ' . $name);
        }

        try {
            $instance = $reflection->newInstance(
                $this->namespacesPaths,
                $this->sanitizeEncoding,
                $this->companyNumber,
                $resolveOptions,
                $this->normalizerFactory,
            );
            // @codeCoverageIgnoreStart
        } catch (ReflectionException) {
            throw new DomainException('Entity initialization failed: ' . $name);
        }
        // @codeCoverageIgnoreEnd

        if (!is_a($instance, Document\AbstractPart::class)) {
            throw new DomainException('Entity is not an instance of AbstractPart: ' . $name);
        }

        return $instance;
    }
}
