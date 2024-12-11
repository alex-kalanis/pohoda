<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Contract;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Type\Address;

class Desc extends AbstractAgenda
{
    use AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['number', 'responsiblePerson'];

    /** @var string[] */
    protected array $elements = ['number', 'datePlanStart', 'datePlanDelivery', 'dateStart', 'dateDelivery', 'dateWarranty', 'text', 'partnerIdentity', 'responsiblePerson', 'note'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process partner identity
        if (isset($data['partnerIdentity'])) {
            $data['partnerIdentity'] = new Address($data['partnerIdentity'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contractDesc', '', $this->namespace('con'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('datePlanStart', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('datePlanDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateStart', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateWarranty', $this->normalizerFactory->getClosure('date'));
        $resolver->setRequired('text');
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string90'));
    }
}
