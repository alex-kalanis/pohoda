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
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['storage', 'typePrice', 'typeRP', 'supplier', 'typeServiceMOSS'];

    /** @var string[] */
    protected array $elements = ['stockType', 'code', 'EAN', 'PLU', 'isSales', 'isSerialNumber', 'isInternet', 'isBatch', 'purchasingRateVAT', 'sellingRateVAT', 'name', 'nameComplement', 'unit', 'unit2', 'unit3', 'coefficient2', 'coefficient3', 'storage', 'typePrice', 'purchasingPrice', 'purchasingPricePayVAT', 'sellingPrice', 'sellingPricePayVAT', 'limitMin', 'limitMax', 'mass', 'volume', 'supplier', 'orderName', 'orderQuantity', 'shortName', 'typeRP', 'guaranteeType', 'guarantee', 'producer', 'typeServiceMOSS', 'description', 'description2', 'note', 'intrastat', 'recyclingContrib'];

    /** @var int */
    protected int $imagesCounter = 0;

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
        // init attributes
        $this->elementsAttributesMapper = [
            'purchasingPricePayVAT' => new Common\ElementAttributes('purchasingPrice', 'payVAT'),
            'sellingPricePayVAT' => new Common\ElementAttributes('sellingPrice', 'payVAT'),
        ];

        // process intrastat
        if (isset($data['intrastat'])) {
            $data['intrastat'] = new Intrastat($namespacesPaths, $sanitizeEncoding, $data['intrastat'], $companyRegistrationNumber, $resolveOptions);
        }

        // process recyclingContrib
        if (isset($data['recyclingContrib'])) {
            $data['recyclingContrib'] = new RecyclingContrib($namespacesPaths, $sanitizeEncoding, $data['recyclingContrib'], $companyRegistrationNumber, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
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

        $this->data['pictures'][] = new Picture($this->namespacesPaths, $this->sanitizeEncoding, [
            'filepath' => $filepath,
            'description' => $description,
            'order' => null === $order ? ++$this->imagesCounter : $order,
            'default' => $default
        ], $this->companyRegistrationNumber);
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

        $this->data['categories'][] = new Category($this->namespacesPaths, $this->sanitizeEncoding, [
            'idCategory' => $categoryId
        ], $this->companyRegistrationNumber);
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

        $this->data['intParameters'][] = new IntParameter($this->namespacesPaths, $this->sanitizeEncoding, $data, $this->companyRegistrationNumber);
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
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setDefault('stockType', 'card');
        $resolver->setAllowedValues('stockType', ['card', 'text', 'service', 'package', 'set', 'product']);
        $resolver->setNormalizer('isSales', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('isSerialNumber', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('isInternet', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('isBatch', $this->normalizerFactory->getClosure('bool'));
        $resolver->setAllowedValues('purchasingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setAllowedValues('sellingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('name', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('nameComplement', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('unit2', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('unit3', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('coefficient2', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('coefficient3', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('purchasingPrice', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('purchasingPricePayVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('sellingPrice', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('sellingPricePayVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('limitMin', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('limitMax', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('mass', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('volume', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('orderName', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('orderQuantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('shortName', $this->normalizerFactory->getClosure('string24'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('guarantee', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('producer', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('description', $this->normalizerFactory->getClosure('string240'));
    }
}
