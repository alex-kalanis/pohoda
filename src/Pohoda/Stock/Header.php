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
    protected array $elements = ['stockType', 'code', 'EAN', 'PLU', 'isSales', 'isSerialNumber', 'isInternet', 'isBatch', 'purchasingRateVAT', 'purchasingRatePayVAT', 'sellingRateVAT', 'sellingRatePayVAT', 'name', 'nameComplement', 'unit', 'unit2', 'unit3', 'coefficient2', 'coefficient3', 'storage', 'typePrice', 'purchasingPrice', 'purchasingPricePayVAT', 'sellingPrice', 'sellingPricePayVAT', 'limitMin', 'limitMax', 'mass', 'volume', 'supplier', 'orderName', 'orderQuantity', 'shortName', 'typeRP', 'guaranteeType', 'guarantee', 'producer', 'typeServiceMOSS', 'description', 'description2', 'note', 'intrastat', 'recyclingContrib'];

    /** @var string[] */
    protected array $additionalElements = ['id', 'weightedPurchasePrice', 'count', 'countIssue', 'countReceivedOrders', 'reservation', 'countIssuedOrders', 'clearanceSale', 'controlLimitTaxLiability', 'discount', 'fixation', 'markRecord', 'news', 'prepare', 'recommended', 'sale', 'reclamation', 'service'];

    /** @var int */
    protected int $imagesCounter = 0;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'purchasingPricePayVAT' => new Common\ElementAttributes('purchasingPrice', 'payVAT'),
            'sellingPricePayVAT' => new Common\ElementAttributes('sellingPrice', 'payVAT'),
            'purchasingRatePayVAT' => new Common\ElementAttributes('purchasingRateVAT', 'value'),
            'sellingRatePayVAT' => new Common\ElementAttributes('sellingRateVAT', 'value'),
        ];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $normalizerFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process intrastat
        if (isset($data['intrastat'])) {
            $intrastat = new Intrastat($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data['intrastat'] = $intrastat->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['intrastat']);
        }

        // process recyclingContrib
        if (isset($data['recyclingContrib'])) {
            $recyclingContrib = new RecyclingContrib($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
            $data['recyclingContrib'] = $recyclingContrib->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['recyclingContrib']);
        }

        return parent::setData($data);
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

        $picture = new Picture($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['pictures'][] = $picture->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData([
            'filepath' => $filepath,
            'description' => $description,
            'order' => null === $order ? ++$this->imagesCounter : $order,
            'default' => $default,
        ]);
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

        $category = new Category($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['categories'][] = $category->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData([
            'idCategory' => $categoryId,
        ]);
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

        $intParameters = new IntParameter($this->namespacesPaths, $this->sanitizeEncoding, $this->normalizerFactory);
        $this->data['intParameters'][] = $intParameters->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockHeader', '', $this->namespace('stk'));

        $this->addElements($xml, \array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : []), ['categories', 'pictures', 'parameters', 'intParameters']), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : [])));

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

        if ($this->useOneDirectionalVariables) {
            $resolver->setNormalizer('weightedPurchasePrice', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('count', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('countIssue', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('countReceivedOrders', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('reservation', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('countIssuedOrders', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('reclamation', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('service', $this->normalizerFactory->getClosure('float'));
            $resolver->setNormalizer('clearanceSale', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('controlLimitTaxLiability', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('discount', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('fixation', $this->normalizerFactory->getClosure('string90'));
            $resolver->setNormalizer('markRecord', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('news', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('prepare', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('recommended', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('sale', $this->normalizerFactory->getClosure('bool'));
        }
    }
}
