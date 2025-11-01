<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = [
        'number',
        'cashAccount',
        'centre',
        'activity',
        'contract',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setAllowedValues('voucherType', ['expense', 'receipt']);
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
