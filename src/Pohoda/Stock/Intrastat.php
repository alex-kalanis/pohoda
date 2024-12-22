<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;


use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;


class Intrastat extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['goodsCode', 'description', 'statistic', 'unit', 'coefficient', 'country'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:intrastat', '', $this->namespace('stk'));

        $this->addElements($xml, $this->elements, 'stk');

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
        $resolver->setNormalizer('goodsCode', $this->normalizerFactory->getClosure('string8'));
        $resolver->setNormalizer('description', $this->normalizerFactory->getClosure('string255'));
        $resolver->setNormalizer('statistic', $this->normalizerFactory->getClosure('string2'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('country', $this->normalizerFactory->getClosure('string2'));
    }
}
