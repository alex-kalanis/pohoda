<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Addressbook;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Type\Address;

class Header extends AbstractAgenda
{
    use AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['paymentType', 'centre', 'activity', 'contract', 'number', 'accountingReceivedInvoice', 'accountingIssuedInvoice', 'classificationVATReceivedInvoice', 'classificationVATIssuedInvoice', 'classificationKVDPHReceivedInvoice', 'classificationKVDPHIssuedInvoice', 'accountForInvoicing', 'foreignCurrency'];

    /** @var string[] */
    protected array $elements = ['identity', 'region', 'phone', 'mobil', 'fax', 'email', 'web', 'ICQ', 'Skype', 'GPS', 'credit', 'priceIDS', 'maturity', 'maturityCommitments', 'paymentType', 'agreement', 'number', 'ost1', 'ost2', 'p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'markRecord', 'message', 'note', 'intNote', 'accountingReceivedInvoice', 'accountingIssuedInvoice', 'classificationVATReceivedInvoice', 'classificationVATIssuedInvoice', 'classificationKVDPHReceivedInvoice', 'classificationKVDPHIssuedInvoice', 'accountForInvoicing', 'foreignCurrency', 'centre', 'activity', 'contract', 'adGroup'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process identity
        if (isset($data['identity'])) {
            $data['identity'] = new Address($data['identity'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
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
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('region', $resolver->getNormalizer('string32'));
        $resolver->setNormalizer('phone', $resolver->getNormalizer('string40'));
        $resolver->setNormalizer('mobil', $resolver->getNormalizer('string24'));
        $resolver->setNormalizer('fax', $resolver->getNormalizer('string24'));
        $resolver->setNormalizer('email', $resolver->getNormalizer('string98'));
        $resolver->setNormalizer('web', $resolver->getNormalizer('string32'));
        $resolver->setNormalizer('ICQ', $resolver->getNormalizer('string12'));
        $resolver->setNormalizer('Skype', $resolver->getNormalizer('string32'));
        $resolver->setNormalizer('GPS', $resolver->getNormalizer('string38'));
        $resolver->setNormalizer('credit', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceIDS', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('maturity', $resolver->getNormalizer('int'));
        $resolver->setNormalizer('agreement', $resolver->getNormalizer('string12'));
        $resolver->setNormalizer('ost1', $resolver->getNormalizer('string8'));
        $resolver->setNormalizer('ost2', $resolver->getNormalizer('string8'));
        $resolver->setNormalizer('p1', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('p2', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('p3', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('p4', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('p5', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('p6', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('markRecord', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('message', $resolver->getNormalizer('string64'));
    }
}
