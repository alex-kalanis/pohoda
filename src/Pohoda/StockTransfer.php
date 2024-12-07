<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\AddParameterToHeaderTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\StockTransfer\Header;
use Riesenia\Pohoda\StockTransfer\Item;

class StockTransfer extends AbstractAgenda
{
    use AddParameterToHeaderTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // pass to header
        $data = ['header' => new Header($data, $ico, $resolveOptions)];

        parent::__construct($data, $ico, $resolveOptions);
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

        $this->data['prevodkaDetail'][] = new Item($data, $this->ico);

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
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['header']);
    }
}
