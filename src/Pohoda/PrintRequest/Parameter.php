<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Parameter extends AbstractAgenda
{
    /** @var string */
    protected string $valueType = 'string';

    /** @var string[] */
    protected array $elements = [
        'value',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $reflect = new \ReflectionClass($this);
        $classname = $reflect->getShortName();
        $xml = $this->createXML()->addChild('prn:'.lcfirst($classname), '', $this->namespace('prn'));

        $this->addElements($xml, $this->elements, 'prn');

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
        $resolver->setNormalizer('value', $this->dependenciesFactory->getNormalizerFactory()->getClosure($this->valueType));
    }
}
