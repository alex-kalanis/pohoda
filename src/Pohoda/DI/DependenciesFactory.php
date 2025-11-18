<?php

declare(strict_types=1);

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\PrintRequest\ParameterInstances;
use kalanis\Pohoda\ValueTransformer;
use Psr\Container\ContainerInterface;

class DependenciesFactory
{
    public function __construct(
        protected ?Common\NamespacesPaths $namespacesPaths = null,
        protected ?ValueTransformer\SanitizeEncoding $sanitizeEncoding = null,
        protected ?Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = null,
        protected readonly ?ContainerInterface $container = null,
        protected ?ParameterInstances $parameterInstances = null,
    ) {}

    public function getAgendaFactory(): AgendaFactoryInterface
    {
        if (empty($this->container) && (empty($this->namespacesPaths) || empty($this->sanitizeEncoding) || empty($this->normalizerFactory))) {
            throw new \LogicException('You must have at least one full set of dependencies to get Agenda factory');
        }
        return $this->container
            ? new AgendaDIFactory($this->container)
            : new AgendaReflectFactory($this)
        ;
    }

    public function getDocumentPartFactory(): DocumentPartFactoryInterface
    {
        if (empty($this->container) && (empty($this->namespacesPaths) || empty($this->sanitizeEncoding) || empty($this->normalizerFactory))) {
            throw new \LogicException('You must have at least one full set of dependencies to get Agenda factory');
        }
        return $this->container
            ? new DocumentPartDIFactory($this->container)
            : new DocumentPartReflectFactory($this)
        ;
    }

    public function getParametersFactory(): ParameterFactoryInterface
    {
        if (empty($this->container) && (empty($this->namespacesPaths) || empty($this->sanitizeEncoding) || empty($this->normalizerFactory))) {
            throw new \LogicException('You must have at least one full set of dependencies to get Parameter factory');
        }
        return $this->container
            ? new ParameterDIFactory($this->container)
            : new ParameterReflectFactory($this)
        ;
    }

    public function getNamespacePaths(): Common\NamespacesPaths
    {
        if (!empty($this->namespacesPaths)) {
            return $this->namespacesPaths;
        }

        $instance = $this->getInstances(Common\NamespacesPaths::class);
        if (!$instance instanceof Common\NamespacesPaths) {
            throw new \LogicException('Container does not return NamespacesPaths class!');
        }

        return $this->namespacesPaths = $instance;
    }

    public function getSanitizeEncoding(): ValueTransformer\SanitizeEncoding
    {
        if (!empty($this->sanitizeEncoding)) {
            return $this->sanitizeEncoding;
        }

        $instance = $this->getInstances(ValueTransformer\SanitizeEncoding::class);
        if (!$instance instanceof ValueTransformer\SanitizeEncoding) {
            throw new \LogicException('Container does not return SanitizeEncoding class!');
        }

        return $this->sanitizeEncoding = $instance;
    }

    public function getNormalizerFactory(): Common\OptionsResolver\Normalizers\NormalizerFactory
    {
        if (!empty($this->normalizerFactory)) {
            return $this->normalizerFactory;
        }

        $instance = $this->getInstances(Common\OptionsResolver\Normalizers\NormalizerFactory::class);
        if (!$instance instanceof Common\OptionsResolver\Normalizers\NormalizerFactory) {
            throw new \LogicException('Container does not return NormalizerFactory class!');
        }

        return $this->normalizerFactory = $instance;
    }

    public function getParameterInstances(): ParameterInstances
    {
        if (!empty($this->parameterInstances)) {
            return $this->parameterInstances;
        }

        $instance = $this->getInstances(ParameterInstances::class);
        if (!$instance instanceof ParameterInstances) {
            throw new \LogicException('Container does not return ParameterInstances class!');
        }

        return $this->parameterInstances = $instance;
    }

    protected function getInstances(string $className): object
    {
        if (empty($this->container)) {
            throw new \LogicException('No DI available, you must set the ' . $className . ' class first!');
        }

        if (!$this->container->has($className)) {
            throw new \LogicException('Container does not have ' . $className . ' class!');
        }

        $instance = $this->container->get($className);
        if (!is_object($instance)) {
            throw new \LogicException('Container does not return ' . $className . ' class!');
        }

        return $instance;
    }
}
