<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ValueTransformer\EncodingTransformer;
use Riesenia\Pohoda\ValueTransformer\ValueTransformer;

/**
 * Base class for Pohoda objects.
 *
 * @method setNamespace($namespace)
 * @method setNodeName($nodeName)
 */
abstract class AbstractAgenda
{
    public static bool $importRecursive = false;

    /** @var array<string, mixed> */
    protected array $data = [];

    /** @var string[] */
    protected array $refElements = [];

    /** @var array<string,array{string,string,string|null}> */
    protected array $elementsAttributesMapper = [];

    /** @var OptionsResolver[] */
    private static array $resolvers = [];

    /**
     * Construct agenda using provided data.
     *
     * @param array<string,mixed> $data
     * @param string              $ico
     * @param bool                $resolveOptions
     */
    public function __construct(
        array $data,
        protected readonly string $ico,
        bool $resolveOptions = true,
    )
    {
        // resolve options
        $this->data = $resolveOptions ? $this->resolveOptions($data) : $data;
    }

    /**
     * Get XML.
     *
     * @return \SimpleXMLElement
     */
    abstract public function getXML(): \SimpleXMLElement;

    /**
     * Configure options for options resolver.
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    abstract protected function configureOptions(OptionsResolver $resolver): void;

    /**
     * Create XML.
     *
     * @return \SimpleXMLElement
     */
    protected function createXML(): \SimpleXMLElement
    {
        return new \SimpleXMLElement('<?xml version="1.0" encoding="' . Pohoda::$encoding . '"?><root ' . \implode(' ', \array_map(function ($k, $v) {
            return 'xmlns:' . $k . '="' . $v . '"';
        }, \array_keys(Pohoda::$namespaces), Pohoda::$namespaces)) . '></root>');
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
        if (!isset(Pohoda::$namespaces[$short])) {
            throw new \OutOfRangeException('Invalid namespace.');
        }

        return Pohoda::$namespaces[$short];
    }

    /**
     * Add batch elements.
     *
     * @param \SimpleXMLElement $xml
     * @param string[]          $elements
     * @param string|null       $namespace
     *
     * @return void
     */
    protected function addElements(\SimpleXMLElement $xml, array $elements, ?string $namespace = null): void
    {
        foreach ($elements as $element) {
            if (!isset($this->data[$element])) {
                continue;
            }

            // ref element
            if (\in_array($element, $this->refElements)) {
                $this->addRefElement($xml, ($namespace ? $namespace . ':' : '') . $element, $this->data[$element], $namespace);

                continue;
            }

            // element attribute
            if (isset($this->elementsAttributesMapper[$element])) {
                list($attrElement, $attrName, $attrNamespace) = $this->elementsAttributesMapper[$element];

                // get element
                $attrElement = $namespace ? $xml->children($namespace, true)->{$attrElement} : $xml->{$attrElement};

                $sanitized = $this->sanitize($this->data[$element]);
                $attrNamespace ? $attrElement->addAttribute($attrNamespace . ':' . $attrName, $sanitized, $this->namespace($attrNamespace)) : $attrElement->addAttribute($attrName, $sanitized);

                continue;
            }

            // Agenda object
            if ($this->data[$element] instanceof self) {
                // set namespace
                if ($namespace && \method_exists($this->data[$element], 'setNamespace')) {
                    $this->data[$element]->setNamespace($namespace);
                }

                // set node name
                if (\method_exists($this->data[$element], 'setNodeName')) {
                    $this->data[$element]->setNodeName($element);
                }

                $this->appendNode($xml, $this->data[$element]->getXML());

                continue;
            }

            // array of Agenda objects
            if (\is_array($this->data[$element])) {
                $child = $namespace ? $xml->addChild($namespace . ':' . $element, '', $this->namespace($namespace)) : $xml->addChild($element);

                foreach ($this->data[$element] as $node) {
                    $this->appendNode($child, $node->getXML());
                }

                continue;
            }

            $sanitized = $this->sanitize($this->data[$element]);
            $namespace ? $xml->addChild($namespace . ':' . $element, $sanitized, $this->namespace($namespace)) : $xml->addChild($element, $sanitized);
        }
    }

    /**
     * Add ref element.
     *
     * @param \SimpleXMLElement $xml
     * @param string            $name
     * @param mixed             $value
     * @param string|null       $namespace
     *
     * @return \SimpleXMLElement
     */
    protected function addRefElement(\SimpleXMLElement $xml, string $name, mixed $value, ?string $namespace = null): \SimpleXMLElement
    {
        $node = $namespace ? $xml->addChild($name, '', $this->namespace($namespace)) : $xml->addChild($name);

        if (!\is_array($value)) {
            $value = ['ids' => $value];
        }

        foreach ($value as $key => $value1) {
            if (\is_array($value1)) {
                if (array_is_list($value1)) {
                    foreach ($value1 as $value2) {
                        $node->addChild($namespace . ':' . $key, $this->sanitize($value2), $this->namespace(strval($namespace)));
                    }
                } else {
                    $node = $node->addChild($namespace . ':' . $key, '', $this->namespace(strval($namespace)));

                    foreach ($value1 as $key2 => $value2) {
                        $node->addChild('typ:' . $key2, $this->sanitize($value2), $this->namespace('typ'));
                    }
                }
            } else {
                $node->addChild('typ:' . $key, $this->sanitize($value1), $this->namespace('typ'));
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
        $transformers = Pohoda::$transformers;

        if (Pohoda::$sanitizeEncoding) {
            $transformers[] = new EncodingTransformer('utf-8', Pohoda::$encoding . '//translit');
            $transformers[] = new EncodingTransformer(Pohoda::$encoding, 'utf-8');
        }

        $value = \array_reduce($transformers, function (string $value, ValueTransformer $transformer): string {
            return $transformer->transform($value);
        }, strval($value));

        return \htmlspecialchars($value);
    }

    /**
     * Append SimpleXMLElement to another SimpleXMLElement.
     *
     * @param \SimpleXMLElement $xml
     * @param \SimpleXMLElement $node
     *
     * @return void
     */
    protected function appendNode(\SimpleXMLElement $xml, \SimpleXMLElement $node): void
    {
        $dom = \dom_import_simplexml($xml);
        $dom2 = \dom_import_simplexml($node);

        if (!$dom->ownerDocument) {
            throw new \InvalidArgumentException('Invalid XML.');
        }

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
        $class = \get_class($this);

        if (!isset(self::$resolvers[$class])) {
            self::$resolvers[$class] = new OptionsResolver();
            $this->configureOptions(self::$resolvers[$class]);
        }

        return self::$resolvers[$class]->resolve($data);
    }
}
