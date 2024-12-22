<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Invoice;


use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;


class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['extId', 'number', 'accounting', 'classificationVAT', 'classificationKVDPH', 'order', 'paymentType', 'priceLevel', 'account', 'paymentAccount', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'carrier'];

    /** @var string[] */
    protected array $elements = ['extId', 'invoiceType', 'number', 'symVar', 'originalDocument', 'originalDocumentNumber', 'symPar', 'date', 'dateTax', 'dateAccounting', 'dateKHDPH', 'dateDue', 'dateApplicationVAT', 'dateDelivery', 'accounting', 'classificationVAT', 'classificationKVDPH', 'numberKHDPH', 'text', 'partnerIdentity', 'myIdentity', 'order', 'numberOrder', 'dateOrder', 'paymentType', 'priceLevel', 'account', 'symConst', 'symSpec', 'paymentAccount', 'paymentTerminal', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'accountingPeriodMOSS', 'dateTaxOriginalDocumentMOSS', 'note', 'carrier', 'intNote', 'postponedIssue', 'histRate'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setDefault('invoiceType', 'issuedInvoice');
        $resolver->setAllowedValues('invoiceType', ['issuedInvoice', 'issuedCreditNotice', 'issuedDebitNote', 'issuedAdvanceInvoice', 'receivable', 'issuedProformaInvoice', 'penalty', 'issuedCorrectiveTax', 'receivedInvoice', 'receivedCreditNotice', 'receivedDebitNote', 'receivedAdvanceInvoice', 'commitment', 'receivedProformaInvoice', 'receivedCorrectiveTax']);
        $resolver->setNormalizer('symVar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('originalDocument', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateTax', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateAccounting', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateKHDPH', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDue', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateApplicationVAT', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('numberKHDPH', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string240'));
        $resolver->setNormalizer('numberOrder', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('dateOrder', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('symConst', $this->normalizerFactory->getClosure('string4'));
        $resolver->setNormalizer('symSpec', $this->normalizerFactory->getClosure('string16'));
        $resolver->setNormalizer('paymentTerminal', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('postponedIssue', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('histRate', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('dateTaxOriginalDocumentMOSS', $this->normalizerFactory->getClosure('date'));
    }
}
