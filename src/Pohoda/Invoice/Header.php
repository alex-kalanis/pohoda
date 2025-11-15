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
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setDefault('invoiceType', 'issuedInvoice');
        $resolver->setAllowedValues('invoiceType', ['issuedInvoice', 'issuedCreditNotice', 'issuedDebitNote', 'issuedAdvanceInvoice', 'receivable', 'issuedProformaInvoice', 'penalty', 'issuedCorrectiveTax', 'receivedInvoice', 'receivedCreditNotice', 'receivedDebitNote', 'receivedAdvanceInvoice', 'commitment', 'receivedProformaInvoice', 'receivedCorrectiveTax']);
        $resolver->setNormalizer('symVar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('originalDocument', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateTax', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateAccounting', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateKHDPH', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateDue', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateApplicationVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('numberKHDPH', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
        $resolver->setNormalizer('numberOrder', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('dateOrder', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('symConst', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string4'));
        $resolver->setNormalizer('symSpec', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string16'));
        $resolver->setNormalizer('paymentTerminal', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('postponedIssue', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('histRate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('dateTaxOriginalDocumentMOSS', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
