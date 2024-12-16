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

class Address extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['extId'];

    /** @var string[] */
    protected array $elements = ['id', 'extId', 'address', 'addressLinkToAddress', 'shipToAddress'];

    /** {@inheritDoc} */
    protected array $elementsAttributesMapper = [
        'addressLinkToAddress' => ['address', 'linkToAddress', null],
    ];

    /**
     * {@inheritdoc}
     */
    public function __construct(Common\NamespacesPaths $namespacesPaths, array $data, string $ico, bool $resolveOptions = true)
    {
        // process address
        if (isset($data['address'])) {
            $data['address'] = new AddressType($namespacesPaths, $data['address'], $ico, $resolveOptions);
        }

        // process shipping address
        if (isset($data['shipToAddress'])) {
            $data['shipToAddress'] = new ShipToAddressType($namespacesPaths, $data['shipToAddress'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $data, $ico, $resolveOptions);
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
