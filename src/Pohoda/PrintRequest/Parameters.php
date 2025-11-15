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
use Riesenia\Pohoda\Common;

class Parameters extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        $parameterFactory = $this->dependenciesFactory->getParametersFactory();
        $parameterInstances = $this->dependenciesFactory->getParameterInstances();

        foreach ($parameterInstances->getKeys() as $key) {
            // add instance to data
            if (isset($data->{$key})) {
                $data->{$key} = $parameterFactory
                    ->getByClassName($parameterInstances->getByKey($key))
                    ->setDirectionalVariable($this->useOneDirectionalVariables)
                    ->setResolveOptions($this->resolveOptions)
                    ->setData($data->{$key});
            }
        }

        // skip undefined - that which stays as AbstractDto class
        $dataKeys = array_keys((array) $data);
        foreach ($dataKeys as $dataKey) {
            if (is_a($data->{$dataKey}, Common\Dtos\AbstractDto::class)) {
                unset($data->{$dataKey});
            }
        }

        $this->data = $this->resolveOptions ? $data : null; // necessary due having dynamic properties
        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:parameters', '', $this->namespace('prn'));

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements(true));

        $resolver->setNormalizer('copy', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('datePrint', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string'));
    }

    protected function getDataElements(bool $withAttributes = false): array
    {
        return $this->data
            ? array_keys((array) $this->data)
            : Common\Dtos\Processing::getProperties(
                $this->getDefaultDto(),
                $withAttributes,
                $this->useOneDirectionalVariables,
            );
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ParametersDto();
    }
}
