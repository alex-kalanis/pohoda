<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IntParam;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Settings extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['currency'];

    /** @var string[] */
    protected array $elements = ['unit', 'length', 'currency', 'parameterList'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ipm:parameterSettings', '', $this->namespace('ipm'));

        $this->addElements($xml, $this->elements, 'ipm');

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
        $resolver->setNormalizer('length', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
    }
}
