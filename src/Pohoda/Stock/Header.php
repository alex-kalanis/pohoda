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
use Riesenia\Pohoda\DI\DependenciesFactory;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['storage', 'typePrice', 'typeRP', 'supplier', 'typeServiceMOSS'];

    /** @var string[] */
    protected array $elements = ['stockType', 'code', 'EAN', 'PLU', 'isSales', 'isSerialNumber', 'isInternet', 'isBatch', 'purchasingRateVAT', 'sellingRateVAT', 'name', 'nameComplement', 'unit', 'unit2', 'unit3', 'coefficient2', 'coefficient3', 'storage', 'typePrice', 'purchasingPrice', 'purchasingPricePayVAT', 'sellingPrice', 'sellingPricePayVAT', 'limitMin', 'limitMax', 'mass', 'volume', 'supplier', 'orderName', 'orderQuantity', 'shortName', 'typeRP', 'guaranteeType', 'guarantee', 'producer', 'typeServiceMOSS', 'description', 'description2', 'note', 'intrastat', 'recyclingContrib'];

    /** @var string[] */
    protected array $additionalElements = ['weightedPurchasePrice', 'count', 'countIssue', 'countReceivedOrders', 'reservation', 'countIssuedOrders', 'reclamation', 'service'];

    /** @var int */
    protected int $imagesCounter = 0;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'purchasingPricePayVAT' => new Common\ElementAttributes('purchasingPrice', 'payVAT'),
            'sellingPricePayVAT' => new Common\ElementAttributes('sellingPrice', 'payVAT'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process intrastat
        if (isset($data['intrastat'])) {
            $intrastat = new Intrastat($this->dependenciesFactory);
            $data['intrastat'] = $intrastat->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['intrastat']);
        }

        // process recyclingContrib
        if (isset($data['recyclingContrib'])) {
            $recyclingContrib = new RecyclingContrib($this->dependenciesFactory);
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

        $picture = new Picture($this->dependenciesFactory);
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

        $category = new Category($this->dependenciesFactory);
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

        $intParameters = new IntParameter($this->dependenciesFactory);
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
        $resolver->setNormalizer('isSales', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('isSerialNumber', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('isInternet', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('isBatch', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setAllowedValues('purchasingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setAllowedValues('sellingRateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('name', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('nameComplement', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('unit2', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('unit3', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficient2', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('coefficient3', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('purchasingPrice', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('purchasingPricePayVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('sellingPrice', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('sellingPricePayVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('limitMin', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('limitMax', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('mass', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('volume', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('orderName', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('orderQuantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('shortName', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string24'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('guarantee', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('producer', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('description', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));

        if ($this->useOneDirectionalVariables) {
            $resolver->setNormalizer('weightedPurchasePrice', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('count', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('countIssue', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('countReceivedOrders', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('reservation', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('countIssuedOrders', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('reclamation', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
            $resolver->setNormalizer('service', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        }
    }
}
