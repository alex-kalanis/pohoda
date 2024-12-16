<?php

namespace Riesenia\Pohoda;


use DomainException;
use ReflectionClass;
use ReflectionException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class DocumentPartFactory
{
    public function __construct(
        protected readonly NamespacesPaths $namespacesPaths,
        protected readonly SanitizeEncoding $sanitizeEncoding,
        protected readonly string $companyNumber,
    )
    {
    }

    /**
     * @param string $parentClass
     * @param string $name
     * @param array<string,mixed> $data
     * @param bool $resolveOptions
     * @throws DomainException
     * @return Document\AbstractPart
     */
    public function getPart(string $parentClass, string $name, array $data, bool $resolveOptions = true): Document\AbstractPart
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
                $data,
                $this->companyNumber,
                $resolveOptions,
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
