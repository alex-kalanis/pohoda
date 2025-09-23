<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ListRequest\Filter;
use Riesenia\Pohoda\ListRequest\Limit;
use Riesenia\Pohoda\ListRequest\RestrictionData;
use Riesenia\Pohoda\ListRequest\UserFilterName;
use Symfony\Component\OptionsResolver\Options;

class ListRequest extends AbstractAgenda
{
    /**
     * Add limit.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addLimit(array $data): self
    {
        $limit = new Limit($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
        $this->data['limit'] = $limit->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * Add filter.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addFilter(array $data): self
    {
        $filter = new Filter($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
        $this->data['filter'] = $filter->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * Add restriction data.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addRestrictionData(array $data): self
    {
        $restrictionData = new RestrictionData($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
        $this->data['restrictionData'] = $restrictionData->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);

        return $this;
    }

    /**
     * Add user filter name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function addUserFilterName(string $name): self
    {
        $userFilterName = new UserFilterName($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);
        $this->data['userFilterName'] = $userFilterName->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData(['userFilterName' => $name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        // UserList is custom
        if ('UserList' == $this->data['type']) {
            $xml = $this->createXML()->addChild($this->data['namespace'] . ':listUserCodeRequest', '', $this->namespace(strval($this->data['namespace'])));
            $xml->addAttribute('version', '1.1');
            $xml->addAttribute('listVersion', '1.1');
        } else {
            $xml = $this->createXML()->addChild($this->data['namespace'] . ':list' . $this->data['type'] . 'Request', '', $this->namespace(strval($this->data['namespace'])));
            $xml->addAttribute('version', '2.0');

            // IntParam doesn't have the version attribute
            if ('IntParam' != $this->data['type']) {
                $xml->addAttribute($this->getLcFirstType() . 'Version', '2.0');
            }

            if (isset($this->data[$this->getLcFirstType() . 'Type'])) {
                $xml->addAttribute($this->getLcFirstType() . 'Type', strval($this->data[$this->getLcFirstType() . 'Type']));
            }

            $request = $xml->addChild($this->data['namespace'] . ':request' . $this->data['type']);

            $this->addElements($request, ['limit', 'filter', 'userFilterName'], 'ftr');

            if (isset($this->data['restrictionData'])) {
                $this->addElements($xml, ['restrictionData'], 'lst');
            }
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['type', 'namespace', 'orderType', 'invoiceType']);

        // validate / format options
        $resolver->setRequired('type');
        $resolver->setNormalizer('type', $this->normalizerFactory->getClosure('list_request_type'));
        $resolver->setDefault('namespace', function (Options $options) {
            if ('Stock' == $options['type']) {
                return 'lStk';
            }

            if ('AddressBook' == $options['type']) {
                return 'lAdb';
            }

            return 'lst';
        });
        $resolver->setAllowedValues('orderType', [null, 'receivedOrder', 'issuedOrder']);
        $resolver->setDefault('orderType', function (Options $options) {
            if ('Order' == $options['type']) {
                return 'receivedOrder';
            }

            return null;
        });
        $resolver->setAllowedValues('invoiceType', [null, 'issuedInvoice', 'issuedCreditNotice', 'issuedDebitNote', 'issuedAdvanceInvoice', 'receivable', 'issuedProformaInvoice', 'penalty', 'issuedCorrectiveTax', 'receivedInvoice', 'receivedCreditNotice', 'receivedDebitNote', 'receivedAdvanceInvoice', 'commitment', 'receivedProformaInvoice', 'receivedCorrectiveTax']);
        $resolver->setDefault('invoiceType', function (Options $options) {
            if ('Invoice' == $options['type']) {
                return 'issuedInvoice';
            }

            return null;
        });
    }

    /**
     * Get LC first type name.
     *
     * @return string
     */
    protected function getLcFirstType(): string
    {
        // ActionPrice is custom
        if ('ActionPrice' == $this->data['type']) {
            return 'actionPrices';
        }

        return \lcfirst(strval($this->data['type']));
    }
}
