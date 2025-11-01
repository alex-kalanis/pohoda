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

class RecyclingContrib extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = [
        'recyclingContribType',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setNormalizer('recyclingContribText', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('recyclingContribAmount', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('recyclingContribUnit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficientOfRecyclingContrib', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\RecyclingContribDto();
    }
}
