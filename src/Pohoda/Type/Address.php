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
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
        Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    )
    {
        // init attributes
        $this->elementsAttributesMapper = [
            'addressLinkToAddress' => new Common\ElementAttributes('address', 'linkToAddress'),
        ];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $resolveOptions, $normalizerFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process address
        if (isset($data['address'])) {
            $address = new AddressType($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['address'] = $address->setData($data['address']);
        }

        // process shipping address
        if (isset($data['shipToAddress'])) {
            $shipTo = new ShipToAddressType($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['shipToAddress'] = $shipTo->setData($data['shipToAddress']);
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

        // validate / format options
        $resolver->setNormalizer('id', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('addressLinkToAddress', $this->normalizerFactory->getClosure('bool'));
    }
}
