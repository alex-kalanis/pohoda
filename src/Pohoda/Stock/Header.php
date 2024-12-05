<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\OptionsResolver;

class Header extends AbstractAgenda
{
    use AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['storage', 'typePrice', 'typeRP', 'supplier', 'typeServiceMOSS'];

    /** {@inheritDoc} */
    protected array $elementsAttributesMapper = [
        'purchasingPricePayVAT' => ['purchasingPrice', 'payVAT', null],
        'sellingPricePayVAT' => ['sellingPrice', 'payVAT', null]
    ];

    /** @var string[] */
    protected array $elements = ['stockType', 'code', 'EAN', 'PLU', 'isSales', 'isSerialNumber', 'isInternet', 'isBatch', 'purchasingRateVAT', 'sellingRateVAT', 'name', 'nameComplement', 'unit', 'unit2', 'unit3', 'coefficient2', 'coefficient3', 'storage', 'typePrice', 'purchasingPrice', 'purchasingPricePayVAT', 'sellingPrice', 'sellingPricePayVAT', 'limitMin', 'limitMax', 'mass', 'volume', 'supplier', 'orderName', 'orderQuantity', 'shortName', 'typeRP', 'guaranteeType', 'guarantee', 'producer', 'typeServiceMOSS', 'description', 'description2', 'note', 'intrastat', 'recyclingContrib'];

    /** @var int */
    protected int $imagesCounter = 0;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process intrastat
        if (isset($data['intrastat'])) {
            $data['intrastat'] = new Intrastat($data['intrastat'], $ico, $resolveOptions);
        }

        // process recyclingContrib
        if (isset($data['recyclingContrib'])) {
            $data['recyclingContrib'] = new RecyclingContrib($data['recyclingContrib'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
    }

    /**
     * Add image.
     *
     * @param string   $filepath
     * @param string   $description
     * @param int|null $order
     * @param bool     $default
     *
     * @return void
     */
    public function addImage(string $filepath, string $description = '', int $order = null, bool $default = false): void
    {
        if (!isset($this->data['pictures'])
            || !(
                is_array($this->data['pictures'])
                || (is_object($this->data['pictures']) && is_a($this->data['pictures'], \ArrayAccess::class))
            )
        ) {
            $this->data['pictures'] = [];
        }

        $this->data['pictures'][] = new Picture([
            'filepath' => $filepath,
            'description' => $description,
            'order' => null === $order ? ++$this->imagesCounter : $order,
            'default' => $default
        ], $this->ico);
    }

    /**
     * Add category.
     *
     * @param int $categoryId
     *
     * @return void
     */
    public function addCategory(int $categoryId): void
    {
        if (!isset($this->data['categories'])
            || !(
                is_array($this->data['categories'])
                || (is_object($this->data['categories']) && is_a($this->data['categories'], \ArrayAccess::class))
            )
        ) {
            $this->data['categories'] = [];
        }

        $this->data['categories'][] = new Category([
            'idCategory' => $categoryId
        ], $this->ico);
    }

    /**
     * Add int parameter.
     *
     * @param array<string,mixed> $data
     *
     * @return void
     */
    public function addIntParameter(array $data): void
    {
        if (!isset($this->data['intParameters'])
            || !(
                is_array($this->data['intParameters'])
                || (is_object($this->data['intParameters']) && is_a($this->data['intParameters'], \ArrayAccess::class))
            )
        ) {
            $this->data['intParameters'] = [];
        }

        $this->data['intParameters'][] = new IntParameter($data, $this->ico);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockHeader', '', $this->namespace('stk'));

        $this->addElements($xml, \array_merge($this->elements, ['categories', 'pictures', 'parameters', 'intParameters']), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setDefault('stockType', 'card');
        $resolver->setAllowedValues('stockType', ['card', 'text', 'service', 'package', 'set', 'product']);
        $resolver->setNormalizer('isSales', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('isSerialNumber', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('isInternet', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('isBatch', $resolver->getNormalizer('bool'));
        $resolver->setAllowedValues('purchasingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setAllowedValues('sellingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('name', $resolver->getNormalizer('string90'));
        $resolver->setNormalizer('nameComplement', $resolver->getNormalizer('string90'));
        $resolver->setNormalizer('unit', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('unit2', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('unit3', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('coefficient2', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('coefficient3', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('purchasingPrice', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('purchasingPricePayVAT', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('sellingPrice', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('sellingPricePayVAT', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('limitMin', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('limitMax', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('mass', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('volume', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('orderName', $resolver->getNormalizer('string90'));
        $resolver->setNormalizer('orderQuantity', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('shortName', $resolver->getNormalizer('string24'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('guarantee', $resolver->getNormalizer('int'));
        $resolver->setNormalizer('producer', $resolver->getNormalizer('string90'));
        $resolver->setNormalizer('description', $resolver->getNormalizer('string240'));
    }
}
