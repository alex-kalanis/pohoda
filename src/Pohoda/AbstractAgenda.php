<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

use InvalidArgumentException;
use ReflectionException;
use SimpleXMLElement;

/**
 * Base class for Pohoda objects.
 *
 * @method \void setNamespace(string $namespace)
 * @method \void setNodeName(string $nodeName)
 */
abstract class AbstractAgenda
{
    use Common\OneDirectionalVariablesTrait;
    use Common\ResolveOptionsTrait;
    use Common\DirectionAsResponseTrait;

    protected Common\Dtos\AbstractDto $data;

    /**
     * Construct agenda using provided data.
     *
     * @param DI\DependenciesFactory $dependenciesFactory
     */
    public function __construct(
        protected readonly DI\DependenciesFactory $dependenciesFactory,
    ) {
        $this->data = $this->getDefaultDto();
    }

    /**
     * Import root
     *
     * string for xml node, null for not existing one
     *
     * @return string|null
     */
    public function getImportRoot(): ?string
    {
        return null;
    }

    /**
     * Can read data recursively
     *
     * @return bool
     */
    public function canImportRecursive(): bool
    {
        return false;
    }

    /**
     * Set & resolve data options
     * Necessary for late setting when there is more options available
     *
     * @param Common\Dtos\AbstractDto $data
     *
     * @throws ReflectionException
     *
     * @return $this
     */
    public function setData(Common\Dtos\AbstractDto $data): self
    {
        // resolve options
        if ($this->resolveOptions) {
            $filteredData = Common\Dtos\Processing::filterUnusableData((array) $data);
            $resolvedData = $this->resolveOptions($filteredData);
            $this->data = Common\Dtos\Processing::hydrate($data, $resolvedData, $this->useOneDirectionalVariables);
        } else {
            $this->data = $data;
        }

        return $this;
    }

    /**
     * Get XML.
     *
     * @return SimpleXMLElement
     */
    abstract public function getXML(): SimpleXMLElement;

    /**
     * Configure options for options resolver.
     *
     * @param Common\OptionsResolver $resolver
     *
     * @return void
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        $resolver->setDefined($this->getDataElements(true));
        Common\OptionsResolver\Normalizers\NormalizerFactory::loadNormalizersFromDto($resolver, $this->data, $this->useOneDirectionalVariables);
    }

    /**
     * Create XML.
     *
     * @return SimpleXMLElement
     */
    protected function createXML(): SimpleXMLElement
    {
        $np = $this->dependenciesFactory->getNamespacePaths()->allNamespaces();
        return new SimpleXMLElement('<?xml version="1.0" encoding="' . $this->dependenciesFactory->getSanitizeEncoding()->getEncoding() . '"?><root ' . \implode(' ', \array_map(function ($k, $v) {
            return 'xmlns:' . $k . '="' . $v . '"';
        }, \array_keys($np), \array_values($np))) . '></root>');
    }

    /**
     * Get namespace.
     *
     * @param string $short
     *
     * @return string
     */
    protected function namespace(string $short): string
    {
        return $this->dependenciesFactory->getNamespacePaths()->namespace($short);
    }

    /**
     * Add batch elements.
     *
     * @param SimpleXMLElement $xml
     * @param string[]         $elements
     * @param string|null      $namespace
     *
     * @return void
     */
    protected function addElements(SimpleXMLElement $xml, array $elements, ?string $namespace = null): void
    {
        $refElements = Common\Dtos\Processing::getRefAttributes($this->data, $this->useOneDirectionalVariables);
        $elementsAttributesMapper = Common\Dtos\Processing::getAttributesExtendingElements($this->data, $this->useOneDirectionalVariables);
        foreach ($elements as $element) {
            $nodeKey = $this->getNodeKey($element);

            if (!isset($this->data->{$element})) {
                continue;
            }
            $subElement = $this->data->{$element};

            // ref element
            if (\in_array($nodeKey, $refElements)) {
                $this->addRefElement(
                    $xml,
                    ($namespace ? $namespace . ':' : '') . $nodeKey,
                    $subElement,
                    $namespace,
                );
                continue;
            }

            // element attribute
            if (isset($elementsAttributesMapper[$nodeKey])) {
                $attrs = $elementsAttributesMapper[$nodeKey];

                // get element
                $attrElement = $namespace ? $xml->children($namespace, true)->{$attrs->attrElement} : $xml->{$attrs->attrElement};

                $sanitized = $this->sanitize($subElement);
                $attrs->attrNamespace
                    ? $attrElement->addAttribute(
                        $attrs->attrNamespace . ':' . $attrs->attrName,
                        $sanitized,
                        $this->namespace($attrs->attrNamespace),
                    )
                    : $attrElement->addAttribute($attrs->attrName, $sanitized);

                continue;
            }

            // Agenda object
            if ($subElement instanceof self) {
                // set namespace
                if ($namespace && \method_exists($subElement, 'setNamespace')) {
                    $subElement->setNamespace($namespace);
                }

                // set node name
                if (\method_exists($subElement, 'setNodeName')) {
                    $subElement->setNodeName($nodeKey);
                }

                $this->appendNode(
                    $xml,
                    $subElement->getXML(),
                );

                continue;
            }

            // array of Agenda objects
            if (\is_array($subElement)) {
                if (empty($subElement)) {
                    continue;
                }

                $child = $namespace ? $xml->addChild($namespace . ':' . $nodeKey, '', $this->namespace($namespace)) : $xml->addChild($nodeKey);

                foreach ($subElement as $node) {
                    if (is_a($node, self::class)) {
                        $this->appendNode(
                            $child,
                            $node->getXML(),
                        );
                    }
                }

                continue;
            }

            $sanitized = $this->sanitize($subElement);
            $namespace ? $xml->addChild(
                $namespace . ':' . $nodeKey,
                $sanitized,
                $this->namespace($namespace),
            )
                : $xml->addChild($nodeKey, $sanitized);
        }
    }

    /**
     * Add ref element.
     *
     * @param SimpleXMLElement $xml
     * @param string           $name
     * @param mixed            $value
     * @param string|null      $namespace
     *
     * @return SimpleXMLElement
     */
    protected function addRefElement(SimpleXMLElement $xml, string $name, mixed $value, ?string $namespace = null): SimpleXMLElement
    {
        $node = $namespace ?
            $xml->addChild(
                $name,
                '',
                $this->namespace($namespace),
            )
            : $xml->addChild($name);

        if (!\is_array($value)) {
            $value = ['ids' => $value];
        }

        foreach ($value as $key => $value1) {
            if (\is_array($value1)) {
                if (array_is_list($value1)) {
                    foreach ($value1 as $value2) {
                        $node->addChild(
                            $namespace . ':' . $key,
                            $this->sanitize($value2),
                            $this->namespace(\strval($namespace)),
                        );
                    }
                } else {
                    $node = $node->addChild(
                        $namespace . ':' . $key,
                        '',
                        $this->namespace(\strval($namespace)),
                    );

                    foreach ($value1 as $key2 => $value2) {
                        $node->addChild(
                            'typ:' . $key2,
                            $this->sanitize($value2),
                            $this->namespace('typ'),
                        );
                    }
                }
            } else {
                $node->addChild(
                    'typ:' . $key,
                    $this->sanitize($value1),
                    $this->namespace('typ'),
                );
            }
        }

        return $node;
    }

    /**
     * Sanitize value to XML.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function sanitize(mixed $value): string
    {
        $sanitizeEncoding = $this->dependenciesFactory->getSanitizeEncoding();
        $sanitizeEncoding->listingWithEncoding();

        return \htmlspecialchars(
            \array_reduce(
                $sanitizeEncoding->getListing()->getTransformers(),
                function (string $value, ValueTransformer\ValueTransformerInterface $transformer): string {
                    return $transformer->transform($value);
                },
                \strval($value),
            ),
        );
    }

    /**
     * Append SimpleXMLElement to another SimpleXMLElement.
     *
     * @param SimpleXMLElement $xml
     * @param SimpleXMLElement $node
     *
     * @return void
     */
    protected function appendNode(SimpleXMLElement $xml, SimpleXMLElement $node): void
    {
        $dom = \dom_import_simplexml($xml);
        $dom2 = \dom_import_simplexml($node);

        if (!$dom->ownerDocument) {
            // @codeCoverageIgnoreStart
            throw new InvalidArgumentException('Invalid XML.');
        }
        // @codeCoverageIgnoreEnd

        $dom->appendChild($dom->ownerDocument->importNode($dom2, true));
    }

    /**
     * Resolve options.
     *
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    protected function resolveOptions(array $data): array
    {
        $resolver = Common\SharedResolver::getResolver($this, $this->useOneDirectionalVariables, $data);
        $this->configureOptions($resolver);
        return $resolver->resolve($data);
    }

    /**
     * Change key in entry to different one in accordance with import root config
     *
     * @param string $defaultKey
     *
     * @return string
     */
    protected function getChildKey(string $defaultKey): string
    {
        if (!empty($this->getImportRoot()) && $this->directionAsResponse) {
            return $this->getImportRoot();
        }
        return $defaultKey;
    }

    /**
     * Change namespace prefix to different one in accordance with import root config
     *
     * @param string $defaultPrefix
     *
     * @return string
     */
    protected function getChildNamespacePrefix(string $defaultPrefix): string
    {
        if (!empty($this->getImportRoot()) && $this->directionAsResponse) {
            list($prefix, ) = explode(':', $this->getImportRoot());
            return $prefix;
        }
        return $defaultPrefix;
    }

    /**
     * Get elements - properties in data class
     *
     * @param bool $withAttributes
     *
     * @return string[]
     */
    protected function getDataElements(bool $withAttributes = false): array
    {
        return Common\Dtos\Processing::getProperties(
            $this->data,
            $withAttributes,
            $this->useOneDirectionalVariables,
        );
    }

    /**
     * Change key for specific cases
     *
     * @param string $key
     *
     * @return string
     */
    protected function getNodeKey(string $key): string
    {
        return $key;
    }

    /**
     * Get DTO which has defined elements for the agenda
     *
     * @return Common\Dtos\AbstractDto
     */
    abstract protected function getDefaultDto(): Common\Dtos\AbstractDto;
}
