<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Symfony\Component\OptionsResolver\Options;

/**
 * @property array{
 *     type: string,
 *     namespace: string,
 *     orderType?: string,
 *     invoiceType?: string,
 *     limit?: ListRequest\Limit,
 *     filter?: ListRequest\Filter,
 *     queryFilter?: ListRequest\QueryFilter,
 *     restrictionData?: ListRequest\RestrictionData,
 *     userFilterName?: ListRequest\UserFilterName,
 * } $data
 */
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
        $limit = new ListRequest\Limit($this->dependenciesFactory);
        $limit->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['limit'] = $limit;

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
        $filter = new ListRequest\Filter($this->dependenciesFactory);
        $filter->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['filter'] = $filter;

        return $this;
    }

    /**
     * Add query filter.
     * Beware! This one is direct SQL!
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addQueryFilter(array $data): self
    {
        $filter = new ListRequest\QueryFilter($this->dependenciesFactory);
        $filter->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['queryFilter'] = $filter;

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
        $restrictionData = new ListRequest\RestrictionData($this->dependenciesFactory);
        $restrictionData->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['restrictionData'] = $restrictionData;

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
        $userFilterName = new ListRequest\UserFilterName($this->dependenciesFactory);
        $userFilterName->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData(['userFilterName' => $name]);
        $this->data['userFilterName'] = $userFilterName;

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

            $this->addElements($request, ['limit', 'filter', 'queryFilter', 'userFilterName'], 'ftr');

            if (isset($this->data['restrictionData'])) {
                $this->addElements($xml, ['restrictionData'], 'lst');
            }
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['type', 'namespace', 'orderType', 'invoiceType']);

        // validate / format options
        $resolver->setRequired('type');
        $resolver->setNormalizer('type', $this->dependenciesFactory->getNormalizerFactory()->getClosure('list_request_type'));
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
