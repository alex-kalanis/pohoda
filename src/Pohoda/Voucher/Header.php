<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\Header as DocumentHeader;

class Header extends DocumentHeader
{
    /** @var string[] */
    protected $_refElements = ['number', 'cashAccount', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected $_elements = [
        'voucherType',
        'cashAccount',
        'number',
        'date',
        'text',
        'partnerIdentity',
        'myIdentity',
        'symPar',
        'centre',
        'activity',
        'contract',
        'note',
        'intNote'
    ];

    /**
     * {@inheritdoc}
     */
    protected function _configureOptions(OptionsResolver $resolver)
    {
        parent::_configureOptions($resolver);

        // validate / format options
        $resolver->setAllowedValues('voucherType', ['expense', 'receipt']);
        $resolver->setNormalizer('date', $resolver->getNormalizer('date'));
        $resolver->setNormalizer('symPar', $resolver->getNormalizer('string20'));
        $resolver->setNormalizer('text', $resolver->getNormalizer('string240'));
    }
}