<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property ListRequest\ListRequestDto $data
 */
class ListRequest extends AbstractAgenda
{
    /**
     * Add limit.
     *
     * @param ListRequest\LimitDto $data
     *
     * @return $this
     */
    public function addLimit(ListRequest\LimitDto $data): self
    {
        $limit = new ListRequest\Limit($this->dependenciesFactory);
        $limit
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->limit = $limit;

        return $this;
    }

    /**
     * Add filter.
     *
     * @param ListRequest\FilterDto $data
     *
     * @return $this
     */
    public function addFilter(ListRequest\FilterDto $data): self
    {
        $filter = new ListRequest\Filter($this->dependenciesFactory);
        $filter
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->filter = $filter;

        return $this;
    }

    /**
     * Add query filter.
     * Beware! This one is direct SQL!
     *
     * @param ListRequest\QueryFilterDto $data
     *
     * @return $this
     */
    public function addQueryFilter(ListRequest\QueryFilterDto $data): self
    {
        $filter = new ListRequest\QueryFilter($this->dependenciesFactory);
        $filter
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->queryFilter = $filter;

        return $this;
    }

    /**
     * Add restriction data.
     *
     * @param ListRequest\RestrictionDataDto $data
     *
     * @return $this
     */
    public function addRestrictionData(ListRequest\RestrictionDataDto $data): self
    {
        $restrictionData = new ListRequest\RestrictionData($this->dependenciesFactory);
        $restrictionData
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->restrictionData = $restrictionData;

        return $this;
    }

    /**
     * Add user filter name.
     *
     * @param ListRequest\UserFilterNameDto $data
     *
     * @return $this
     */
    public function addUserFilterName(ListRequest\UserFilterNameDto $data): self
    {
        $userFilterName = new ListRequest\UserFilterName($this->dependenciesFactory);
        $userFilterName
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->userFilterName = $userFilterName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        // UserList is custom
        if ('UserList' == $this->data->type) {
            $xml = $this->createXML()->addChild($this->data->namespace . ':listUserCodeRequest', '', $this->namespace(\strval($this->data->namespace)));
            $xml->addAttribute('version', '1.1');
            $xml->addAttribute('listVersion', '1.1');
        } else {
            $xml = $this->createXML()->addChild($this->data->namespace . ':list' . $this->data->type . 'Request', '', $this->namespace(\strval($this->data->namespace)));
            $xml->addAttribute('version', '2.0');

            // IntParam doesn't have the version attribute
            if ('IntParam' != $this->data->type) {
                $xml->addAttribute($this->getLcFirstType() . 'Version', '2.0');
            }

            if (isset($this->data->{$this->getLcFirstType() . 'Type'})) {
                $xml->addAttribute($this->getLcFirstType() . 'Type', \strval($this->data->{$this->getLcFirstType() . 'Type'}));
            }

            $request = $xml->addChild($this->data->namespace . ':request' . $this->data->type);

            $this->addElements($request, ['limit', 'filter', 'queryFilter', 'userFilterName'], 'ftr');

            if (isset($this->data->restrictionData)) {
                $this->addElements($xml, ['restrictionData'], 'lst');
            }
        }

        return $xml;
    }

    /**
     * Get LC first type name.
     *
     * @return string
     */
    protected function getLcFirstType(): string
    {
        // ActionPrice is custom
        if ('ActionPrice' == $this->data->type) {
            return 'actionPrices';
        }

        return \lcfirst(\strval($this->data->type));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ListRequest\ListRequestDto();
    }
}
