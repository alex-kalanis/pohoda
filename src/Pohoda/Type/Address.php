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
use Riesenia\Pohoda\DI\DependenciesFactory;

/**
 * @property Dtos\AddressDto $data
 */
class Address extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'addressLinkToAddress' => new Common\ElementAttributes('address', 'linkToAddress'),
        ];

        parent::__construct($dependenciesFactory);
    }

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
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setNormalizer('id', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('addressLinkToAddress', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\AddressDto();
    }
}
