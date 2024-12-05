<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader as DocumentHeader;

class Header extends DocumentHeader
{
    /** @var string[] */
    protected array $refElements = ['number', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['number', 'date', 'dateOfReceipt', 'text', 'partnerIdentity', 'symPar', 'centre', 'activity', 'contract', 'note', 'intNote'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('date', $resolver->getNormalizer('date'));
        $resolver->setNormalizer('dateOfReceipt', $resolver->getNormalizer('?date'));
        $resolver->setNormalizer('symPar', $resolver->getNormalizer('string20'));
        $resolver->setNormalizer('text', $resolver->getNormalizer('string240'));
    }
}
