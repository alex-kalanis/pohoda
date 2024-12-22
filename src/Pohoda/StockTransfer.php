<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class StockTransfer extends AbstractAgenda
{
    use Common\AddParameterToHeaderTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
    )
    {
        // pass to header
        $data = ['header' => new StockTransfer\Header($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions)];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    public function getImportRoot(): string
    {
        return 'lst:prevodka';
    }

    /**
     * Add item.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addItem(array $data): self
    {
        if (!isset($this->data['prevodkaDetail'])
            || !(
                is_array($this->data['prevodkaDetail'])
                || (is_object($this->data['prevodkaDetail']) && is_a($this->data['prevodkaDetail'], \ArrayAccess::class))
            )
        ) {
            $this->data['prevodkaDetail'] = [];
        }

        $this->data['prevodkaDetail'][] = new StockTransfer\Item($this->namespacesPaths, $this->sanitizeEncoding, $data, $this->companyRegistrationNumber);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('pre:prevodka', '', $this->namespace('pre'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['header', 'prevodkaDetail'], 'pre');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }
}
