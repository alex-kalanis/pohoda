<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractItem;
use Riesenia\Pohoda\Type\RecyclingContrib;

class Item extends AbstractItem
{
    /**
     * @inheritdoc
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
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
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('quantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird']);
        $resolver->setNormalizer('percentVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('discountPercentage', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('note', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('code', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('guarantee', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('expirationDate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('PDP', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
