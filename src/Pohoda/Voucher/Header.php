<?php

namespace Riesenia\Pohoda\Voucher;

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

    /** @var string[] */
    protected array $elements = [
        'id',
        'extId',
        'voucherType',
        'storno',
        'cashAccount',
        'number',
        'originalDocument',
        'date',
        'datePayment',
        'dateTax',
        'dateKHDPH',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'text',
        'partnerIdentity',
        'myIdentity',
        'symPar',
        'priceLevel',
        'centre',
        'activity',
        'contract',
        'regVATinEU',
        'MOSS',
        'evidentiaryResourcesMOSS',
        'note',
        'intNote',
        'histRate',
        'lock1',
        'lock2',
        'markRecord',
        'labels',
        'parameters',
        'validate',
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
}
