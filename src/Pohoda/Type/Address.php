<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property Dtos\AddressDto $data
 */
class Address extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process address
        if (isset($data->address)) {
            $address = new AddressType($this->dependenciesFactory);
            $address
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->address);
            $data->address = $address;
        }

        // process shipping address
        if (isset($data->shipToAddress)) {
            $shipTo = new ShipToAddressType($this->dependenciesFactory);
            $shipTo
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->shipToAddress);
            $data->shipToAddress = $shipTo;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\AddressDto();
    }
}
