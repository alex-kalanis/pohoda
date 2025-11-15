<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\DI\DependenciesFactory;

class StockItem extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'insertAttachStock' => new Common\ElementAttributes('stockItem', 'insertAttachStock'),
            'applyUserSettingsFilterOnTheStore' => new Common\ElementAttributes('stockItem', 'applyUserSettingsFilterOnTheStore'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setNormalizer('insertAttachStock', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('applyUserSettingsFilterOnTheStore', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('serialNumber', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string40'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\StockItemDto();
    }
}
