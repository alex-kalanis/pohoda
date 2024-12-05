<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\AddParameterTrait;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Type\Address;

class Header extends AbstractAgenda
{
    use AddParameterTrait;

    /** @var string[] */
    protected array $refElements = ['number', 'store', 'centreSource', 'centreDestination', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['number', 'date', 'time', 'dateOfReceipt', 'timeOfReceipt', 'symPar', 'store', 'text', 'partnerIdentity', 'centreSource', 'centreDestination', 'activity', 'contract', 'note', 'intNote'];

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
        $xml = $this->createXML()->addChild('pre:prevodkaHeader', '', $this->namespace('pre'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'pre');

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
        $resolver->setNormalizer('date', $resolver->getNormalizer('date'));
        $resolver->setNormalizer('time', $resolver->getNormalizer('time'));
        $resolver->setNormalizer('dateOfReceipt', $resolver->getNormalizer('date'));
        $resolver->setNormalizer('timeOfReceipt', $resolver->getNormalizer('time'));
        $resolver->setNormalizer('symPar', $resolver->getNormalizer('string20'));
        $resolver->setNormalizer('text', $resolver->getNormalizer('string48'));
    }
}
