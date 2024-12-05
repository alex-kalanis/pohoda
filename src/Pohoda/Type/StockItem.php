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
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Common\SetNamespaceTrait;

class StockItem extends AbstractAgenda
{
    use SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['store', 'stockItem'];

    /** {@inheritDoc} */
    protected array $elementsAttributesMapper = [
        'insertAttachStock' => ['stockItem', 'insertAttachStock', null],
        'applyUserSettingsFilterOnTheStore' => ['stockItem', 'applyUserSettingsFilterOnTheStore', null]
    ];

    /** @var string[] */
    protected array $elements = ['store', 'stockItem', 'insertAttachStock', 'applyUserSettingsFilterOnTheStore', 'serialNumber'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('insertAttachStock', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('applyUserSettingsFilterOnTheStore', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('serialNumber', $resolver->getNormalizer('string40'));
    }
}
