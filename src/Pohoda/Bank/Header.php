<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Bank;


use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractHeader;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['account', 'accounting', 'classificationVAT', 'classificationKVDPH', 'paymentAccount', 'centre', 'activity', 'contract', 'MOSS', 'evidentiaryResourcesMOSS'];

    /** @var string[] */
    protected array $elements = ['bankType', 'account', 'statementNumber', 'symVar', 'dateStatement', 'datePayment', 'accounting', 'classificationVAT', 'classificationKVDPH', 'text', 'partnerIdentity', 'myIdentity', 'paymentAccount', 'symConst', 'symSpec', 'symPar', 'centre', 'activity', 'contract', 'MOSS', 'evidentiaryResourcesMOSS', 'accountingPeriodMOSS', 'note', 'intNote'];

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $ico,
        bool $resolveOptions = true,
    )
    {
        // process report
        if (isset($data['statementNumber'])) {
            $data['statementNumber'] = new StatementNumber($namespacesPaths, $sanitizeEncoding, $data['statementNumber'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setAllowedValues('bankType', ['receipt', 'expense']);
        $resolver->setNormalizer('symVar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('dateStatement', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('datePayment', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string96'));
        $resolver->setNormalizer('symConst', $this->normalizerFactory->getClosure('string4'));
        $resolver->setNormalizer('symSpec', $this->normalizerFactory->getClosure('string16'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('accountingPeriodMOSS', $this->normalizerFactory->getClosure('string7'));
    }
}
