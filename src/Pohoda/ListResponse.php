<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\DirectionAsResponseTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\ListRequest\Filter;
use Riesenia\Pohoda\ListRequest\Limit;
use Riesenia\Pohoda\ListRequest\RestrictionData;
use Riesenia\Pohoda\ListRequest\UserFilterName;
use Symfony\Component\OptionsResolver\Options;

class ListResponse extends AbstractAgenda
{
    use DirectionAsResponseTrait;

    /**
     * Add limit.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addLimit(array $data): self
    {
        $limit = new Limit($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $this->data['limit'] = $limit->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data);

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
        $filter = new Filter($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $this->data['filter'] = $filter->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data);

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
        $restrictionData = new RestrictionData($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $this->data['restrictionData'] = $restrictionData->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data);

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
        $userFilterName = new UserFilterName($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        $this->data['userFilterName'] = $userFilterName->setDirectionalVariable($this->useOneDirectionalVariables)->setData(['userFilterName' => $name]);

        return $this;
    }

    /**
     * Add Order as content
     *
     * @param array<string, mixed> $header
     * @param array<array<string, mixed>> $items
     * @param array<string, mixed> $summary
     *
     * @return Order
     *
     * @todo: more orders in one query
     */
    public function addOrder(array $header, array $items = [], array $summary = []): Order
    {
        /*
        if (!isset($this->data['order'])
            || !(
                is_array($this->data['order'])
                || (is_object($this->data['order']) && is_a($this->data['order'], \ArrayAccess::class))
            )
        ) {
            $this->data['order'] = [];
        }
        */
        $order = new Order($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
        // $this->data['order'][] = $order->setDirectionalVariable($this->useOneDirectionalVariables)->setData($header);
        $this->data['order'] = $order->setDirectionalVariable($this->useOneDirectionalVariables)->setData($header);
        foreach ($items as $item) {
            $order->addItem($item);
        }
        if (!empty($summary)) {
            $order->addSummary($summary);
        }

        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        // UserList is custom
        if ('UserList' == $this->data['type']) {
            $xml = $this->createXML()->addChild($this->data['namespace'] . ':listUserCodeResponse', '', $this->namespace(strval($this->data['namespace'])));
            $xml->addAttribute('version', '1.1');
            $xml->addAttribute('listVersion', '1.1');
        } else {
            $xml = $this->createXML()->addChild($this->data['namespace'] . ':list' . $this->data['type'], '', $this->namespace(strval($this->data['namespace'])));
            $xml->addAttribute('version', '2.0');

            // IntParam and Order doesn't have the version attribute
            if (!in_array($this->data['type'], ['IntParam', 'Order'])) {
                $xml->addAttribute($this->getLcFirstType() . 'Version', '2.0');
            }

            if (isset($this->data[$this->getLcFirstType() . 'Type'])) {
                $xml->addAttribute($this->getLcFirstType() . 'Type', strval($this->data[$this->getLcFirstType() . 'Type']));
            }

            if ('Order' == $this->data['type'] && (isset($this->data['order']))) {
                $this->addElements($xml, ['order'], strval($this->data['namespace']));

            } else {
                $request = $xml->addChild($this->data['namespace'] . ':' . $this->whichDirection($this->directionAsResponse) . $this->data['type']);

                $this->addElements($request, ['limit', 'filter', 'userFilterName'], 'ftr');
            }

            if (isset($this->data['restrictionData'])) {
                $this->addElements($xml, ['restrictionData'], 'lst');
            }
        }

        if (isset($this->data['timestamp'])) {
            $date = $this->data['timestamp'];
            if (is_object($date) && is_a($date, \DateTimeInterface::class)) {
                $date = $date->format('Y-m-d\TH:i:s');
            }
            $xml->addAttribute('dateTimeStamp', strval($date));
        }

        if (isset($this->data['validFrom'])) {
            $dateFrom = $this->data['validFrom'];
            if (is_object($dateFrom) && is_a($dateFrom, \DateTimeInterface::class)) {
                $dateFrom = $dateFrom->format('Y-m-d');
            }
            $xml->addAttribute('dateValidFrom', strval($dateFrom));
        }

        if (isset($this->data['state'])) {
            $xml->addAttribute('state', strval($this->data['state']));
        }


        return $xml;
    }

    protected function whichDirection(bool $asResponse): string
    {
        return $asResponse ? 'response' : 'request';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['type', 'namespace', 'order', 'orderType', 'invoiceType', 'timestamp', 'validFrom', 'state']);

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
            /*
            if ('AccountingUnit' == $options['type']) {
                return 'acu';
            }
            */
            if ('Contract' == $options['type']) {
                return 'lCon';
            }
            /*
            if ('Centre' == $options['type']) {
                return 'lCen';
            }

            if ('Activity' == $options['type']) {
                return 'lAcv';
            }
            */
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
