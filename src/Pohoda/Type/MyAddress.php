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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

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
            $address = new AddressInternetType($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['address'] = $address->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['address']);
        }
        // process establishment
        if (isset($data['establishment'])) {
            $establishment = new EstablishmentType($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['establishment'] = $establishment->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['establishment']);
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
