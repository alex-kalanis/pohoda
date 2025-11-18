<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property Dtos\MyAddressDto $data
 */
class MyAddress extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process address
        if (isset($data->address)) {
            $address = new AddressInternetType($this->dependenciesFactory);
            $address
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->address);
            $data->address = $address;
        }
        // process establishment
        if (isset($data->establishment)) {
            $establishment = new EstablishmentType($this->dependenciesFactory);
            $establishment
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->establishment);
            $data->establishment = $establishment;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\MyAddressDto();
    }
}
