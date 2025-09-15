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
    /** @var string[] */
    protected array $elements = ['copy', 'datePrint'];

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        $factory = new ParameterFactory($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->normalizerFactory);

        foreach ($factory->getKeys() as $key) {
            // fill elements from factory
            $this->elements[] = $key;
            // add instance to data
            if (isset($data[$key])) {
                $data[$key] = $factory->getByKey($key, $this->resolveOptions)->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data[$key]);
            }
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:parameters', '', $this->namespace('prn'));

        $this->addElements($xml, $this->elements, 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('copy', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('datePrint', $this->normalizerFactory->getClosure('string'));
    }
}
