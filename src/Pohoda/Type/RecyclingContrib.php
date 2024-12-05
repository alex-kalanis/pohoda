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

class RecyclingContrib extends AbstractAgenda
{
    use SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['recyclingContribType'];

    /** @var string[] */
    protected array $elements = ['recyclingContribText', 'recyclingContribAmount', 'recyclingContribUnit', 'coefficientOfRecyclingContrib'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('recyclingContribText', $resolver->getNormalizer('string64'));
        $resolver->setNormalizer('recyclingContribAmount', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('recyclingContribUnit', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('coefficientOfRecyclingContrib', $resolver->getNormalizer('float'));
    }
}
