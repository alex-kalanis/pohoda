<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type\StockItem;

class Item extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['quantity', 'stockItem', 'note'];

    /**
     * {@inheritdoc}
     */
    public function __construct(Common\NamespacesPaths $namespacesPaths, array $data, string $ico, bool $resolveOptions = true)
    {
        // process stock item
        if (isset($data['stockItem'])) {
            $data['stockItem'] = new StockItem($namespacesPaths, $data['stockItem'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('pre:prevodkaItem', '', $this->namespace('pre'));

        $this->addElements($xml, $this->elements, 'pre');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('note', $this->normalizerFactory->getClosure('string90'));
    }
}
