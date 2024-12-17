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
use Riesenia\Pohoda\Common\OptionsResolver;


class AddressType extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['country'];

    /** @var string[] */
    protected array $elements = ['company', 'division', 'name', 'city', 'street', 'zip', 'ico', 'dic', 'VATPayerType', 'icDph', 'country', 'phone', 'mobilPhone', 'fax', 'email'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:address', '', $this->namespace('typ'));

        $this->addElements($xml, $this->elements, 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('company', $this->normalizerFactory->getClosure('string255'));
        $resolver->setNormalizer('division', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('name', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('city', $this->normalizerFactory->getClosure('string45'));
        $resolver->setNormalizer('street', $this->normalizerFactory->getClosure('string45'));
        $resolver->setNormalizer('zip', $this->normalizerFactory->getClosure('string15'));
        $resolver->setNormalizer('ico', $this->normalizerFactory->getClosure('string15'));
        $resolver->setNormalizer('dic', $this->normalizerFactory->getClosure('string18'));
        $resolver->setAllowedValues('VATPayerType', ['payer', 'non-payer', '']);
        $resolver->setNormalizer('icDph', $this->normalizerFactory->getClosure('string18'));
        $resolver->setNormalizer('phone', $this->normalizerFactory->getClosure('string40'));
        $resolver->setNormalizer('mobilPhone', $this->normalizerFactory->getClosure('string24'));
        $resolver->setNormalizer('fax', $this->normalizerFactory->getClosure('string24'));
        $resolver->setNormalizer('email', $this->normalizerFactory->getClosure('string98'));
    }
}
