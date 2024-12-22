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


class Address extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['extId'];

    /** @var string[] */
    protected array $elements = ['id', 'extId', 'address', 'addressLinkToAddress', 'shipToAddress'];

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
    )
    {
        // init attributes
        $this->elementsAttributesMapper = [
            'addressLinkToAddress' => new Common\ElementAttributes('address', 'linkToAddress'),
        ];

        // process address
        if (isset($data['address'])) {
            $data['address'] = new AddressType($namespacesPaths, $sanitizeEncoding, $data['address'], $companyRegistrationNumber, $resolveOptions);
        }

        // process shipping address
        if (isset($data['shipToAddress'])) {
            $data['shipToAddress'] = new ShipToAddressType($namespacesPaths, $sanitizeEncoding, $data['shipToAddress'], $companyRegistrationNumber, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('id', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('addressLinkToAddress', $this->normalizerFactory->getClosure('bool'));
    }
}
