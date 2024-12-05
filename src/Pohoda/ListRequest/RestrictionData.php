<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class RestrictionData extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [];

    /** @var string[] */
    protected array $elements = ['liquidations'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:restrictionData', '', $this->namespace('lst'));

        $this->addElements($xml, $this->elements, 'lst');

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
        $resolver->setNormalizer('liquidations', $resolver->getNormalizer('bool'));
    }
}
