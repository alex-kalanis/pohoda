<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\AddressBook;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type\Address;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['paymentType', 'centre', 'activity', 'contract', 'number', 'accountingReceivedInvoice', 'accountingIssuedInvoice', 'classificationVATReceivedInvoice', 'classificationVATIssuedInvoice', 'classificationKVDPHReceivedInvoice', 'classificationKVDPHIssuedInvoice', 'accountForInvoicing', 'foreignCurrency'];

    /** @var string[] */
    protected array $elements = ['identity', 'region', 'phone', 'mobil', 'fax', 'email', 'web', 'ICQ', 'Skype', 'GPS', 'credit', 'priceIDS', 'maturity', 'maturityCommitments', 'paymentType', 'agreement', 'number', 'ost1', 'ost2', 'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'markRecord', 'message', 'note', 'intNote', 'accountingReceivedInvoice', 'accountingIssuedInvoice', 'classificationVATReceivedInvoice', 'classificationVATIssuedInvoice', 'classificationKVDPHReceivedInvoice', 'classificationKVDPHIssuedInvoice', 'accountForInvoicing', 'foreignCurrency', 'centre', 'activity', 'contract', 'adGroup'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process identity
        if (isset($data['identity'])) {
            $identity = new Address($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['identity'] = $identity->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['identity']);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('adb:addressbookHeader', '', $this->namespace('adb'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'adb');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('region', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('phone', $this->normalizerFactory->getClosure('string40'));
        $resolver->setNormalizer('mobil', $this->normalizerFactory->getClosure('string24'));
        $resolver->setNormalizer('fax', $this->normalizerFactory->getClosure('string24'));
        $resolver->setNormalizer('email', $this->normalizerFactory->getClosure('string98'));
        $resolver->setNormalizer('web', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('ICQ', $this->normalizerFactory->getClosure('string12'));
        $resolver->setNormalizer('Skype', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('GPS', $this->normalizerFactory->getClosure('string38'));
        $resolver->setNormalizer('credit', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceIDS', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('maturity', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('agreement', $this->normalizerFactory->getClosure('string12'));
        $resolver->setNormalizer('ost1', $this->normalizerFactory->getClosure('string8'));
        $resolver->setNormalizer('ost2', $this->normalizerFactory->getClosure('string8'));
        $resolver->setNormalizer('p1', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('p2', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('p3', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('p4', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('p5', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('p6', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('message', $this->normalizerFactory->getClosure('string64'));
    }
}
