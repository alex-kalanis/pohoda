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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Parameters extends AbstractAgenda
{
    /** @var string[] */
    protected array $elements = ['copy', 'datePrint'];

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
    )
    {
        $factory = new ParameterFactory($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber);

        foreach ($factory->getKeys() as $key) {
            // fill elements from factory
            $this->elements[] = $key;
            // add instance to data
            if (isset($data[$key])) {
                $data[$key] = $factory->getByKey($key, $data[$key], $resolveOptions);
            }
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
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
