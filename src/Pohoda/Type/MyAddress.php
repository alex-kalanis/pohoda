<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

/**
 * @property array{
 *     address?: AddressInternetType,
 *     establishment?: EstablishmentType,
 * } $data
 */
class MyAddress extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $elements = ['address', 'establishment'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process address
        if (isset($data['address'])) {
            $address = new AddressInternetType($this->dependenciesFactory);
            $address->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['address']);
            $data['address'] = $address;
        }
        // process establishment
        if (isset($data['establishment'])) {
            $establishment = new EstablishmentType($this->dependenciesFactory);
            $establishment->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['establishment']);
            $data['establishment'] = $establishment;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
