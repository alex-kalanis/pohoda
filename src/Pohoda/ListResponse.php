<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property ListResponse\ListResponseDto $data
 */
class ListResponse extends AbstractAgenda
{
    use Common\DirectionAsResponseTrait;

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
     * Add Order as content
     *
     * @param Order\OrderDto $dto
     * @param Order\ItemDto[] $items
     * @param Order\SummaryDto|null $summary
     *
     * @return Order
     */
    public function addOrder(Order\OrderDto $dto, array $items = [], ?Order\SummaryDto $summary = null): Order
    {
        $order = new Order($this->dependenciesFactory);
        $order
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($dto);
        $this->data->order[] = $order;
        foreach ($items as $item) {
            $order->addItem($item);
        }
        if (!empty($summary)) {
            $order->addSummary($summary);
        }

        return $order;
    }

    /**
     * Add Stock as content
     *
     * @param Stock\StockDto $dto
     *
     * @return Stock
     */
    public function addStock(Stock\StockDto $dto): Stock
    {
        $stock = new Stock($this->dependenciesFactory);
        $stock
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($dto);
        $this->data->stock[] = $stock;

        return $stock;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        // UserList is custom
        if ('UserList' == $this->data->type) {
            $xml = $this->createXML()->addChild($this->data->namespace . ':listUserCodeResponse', '', $this->namespace(\strval($this->data->namespace)));
            $xml->addAttribute('version', '1.1');
            $xml->addAttribute('listVersion', '1.1');
        } else {
            $xml = $this->createXML()->addChild($this->data->namespace . ':list' . $this->data->type, '', $this->namespace(\strval($this->data->namespace)));
            $xml->addAttribute('version', '2.0');

            // IntParam and Order doesn't have the version attribute
            if (!in_array($this->data->type, ['IntParam', 'Order'])) {
                if (empty($this->data->stock)) {
                    $xml->addAttribute($this->getLcFirstType() . 'Version', '2.0');
                }
            }

            if (isset($this->data->{$this->getLcFirstType() . 'Type'})) {
                $xml->addAttribute($this->getLcFirstType() . 'Type', \strval($this->data->{$this->getLcFirstType() . 'Type'}));
            }

            if ('Order' == $this->data->type && !empty($this->data->order)) {
                foreach ($this->data->order as $orderElement) {
                    $this->appendNode($xml, $orderElement->getXML());
                }

            } elseif ('Stock' == $this->data->type && !empty($this->data->stock)) {
                foreach ($this->data->stock as $stockElement) {
                    // set namespace
                    $stockElement->setNamespace('lStk');
                    $this->appendNode($xml, $stockElement->getXML());
                }

            } else {
                $request = $xml->addChild($this->data->namespace . ':' . $this->whichDirection($this->directionAsResponse) . $this->data->type);

                $this->addElements($request, ['limit', 'filter', 'userFilterName'], 'ftr');
            }

            if (isset($this->data->restrictionData)) {
                $this->addElements($xml, ['restrictionData'], 'lst');
            }
        }

        if (isset($this->data->timestamp)) {
            $date = $this->data->timestamp;
            if (is_object($date) && is_a($date, \DateTimeInterface::class)) {
                $date = $date->format('Y-m-d\TH:i:s');
            }
            $xml->addAttribute('dateTimeStamp', \strval($date));
        }

        if (isset($this->data->validFrom)) {
            $dateFrom = $this->data->validFrom;
            if (is_object($dateFrom) && is_a($dateFrom, \DateTimeInterface::class)) {
                $dateFrom = $dateFrom->format('Y-m-d');
            }
            $xml->addAttribute('dateValidFrom', \strval($dateFrom));
        }

        if (isset($this->data->state)) {
            $xml->addAttribute('state', \strval($this->data->state));
        }


        return $xml;
    }

    protected function whichDirection(bool $asResponse): string
    {
        return $asResponse ? 'response' : 'request';
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
        return new ListResponse\ListResponseDto();
    }
}
