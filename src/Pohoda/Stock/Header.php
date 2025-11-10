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

/**
 * @property HeaderDto $data
 */
class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /** @var string[] */
    protected array $refElements = [
        'storage',
        'typePrice',
        'typeRP',
        'supplier',
        'typeServiceMOSS',
    ];

    /** @var string[] */
    protected array $additionalElements = [
        'id',
        'weightedPurchasePrice',
        'count',
        'countIssue',
        'countReceivedOrders',
        'reservation',
        'countIssuedOrders',
        'clearanceSale',
        'controlLimitTaxLiability',
        'discount',
        'fixation',
        'markRecord',
        'news',
        'prepare',
        'recommended',
        'sale',
        'reclamation',
        'service',
    ];

    protected array $extraGroups = [
        'categories',
        'pictures',
        'parameters',
        'intParameters',
    ];

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
            'purchasingRatePayVAT' => new Common\ElementAttributes('purchasingRateVAT', 'value'),
            'sellingRatePayVAT' => new Common\ElementAttributes('sellingRateVAT', 'value'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // process intrastat
        if (isset($data->intrastat)) {
            $intrastat = new Intrastat($this->dependenciesFactory);
            $intrastat
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->intrastat);
            $data->intrastat = $intrastat;
        }

        // process recyclingContrib
        if (isset($data->recyclingContrib)) {
            $recyclingContrib = new RecyclingContrib($this->dependenciesFactory);
            $recyclingContrib
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->recyclingContrib);
            $data->recyclingContrib = $recyclingContrib;
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
        $pictureDto = new PictureDto();
        $pictureDto->filepath = $filepath;
        $pictureDto->description = $description;
        $pictureDto->order = null === $order ? ++$this->imagesCounter : $order;
        $pictureDto->default = $default;

        $picture = new Picture($this->dependenciesFactory);
        $picture
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($pictureDto);
        $this->data->pictures[] = $picture;
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
        $categoryDto = new CategoryDto();
        $categoryDto->idCategory = $categoryId;

        $category = new Category($this->dependenciesFactory);
        $category
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($categoryDto);
        $this->data->categories[] = $category;
    }

    /**
     * Add int parameter.
     *
     * @param IntParameterDto $data
     *
     * @return void
     */
    public function addIntParameter(IntParameterDto $data): void
    {
        $intParameters = new IntParameter($this->dependenciesFactory);
        $intParameters
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->intParameters[] = $intParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockHeader', '', $this->namespace('stk'));

        $this->addElements($xml,
            $this->useOneDirectionalVariables
                ? $this->getAllDataProperties()
                : \array_diff(
                    $this->getAllDataProperties(),
                    $this->additionalElements,
                )
        , 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

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
            $resolver->setNormalizer('clearanceSale', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('controlLimitTaxLiability', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('discount', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('fixation', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
            $resolver->setNormalizer('markRecord', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('news', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('prepare', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('recommended', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
            $resolver->setNormalizer('sale', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }

    /**
     * {@inheritdoc}
     */
    protected function skipElements(): array
    {
        return array_merge(
            $this->extraGroups,
            $this->useOneDirectionalVariables ? [] : $this->additionalElements,
        );
    }
}
