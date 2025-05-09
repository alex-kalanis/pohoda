<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\IntParam\Settings;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class IntParam extends AbstractAgenda
{

    /** @var string[] */
    protected array $elements = ['name', 'description', 'parameterType', 'parameterSettings'];

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
        // prepare empty parameter list for list
        if ('listValue' == $data['parameterType']) {
            $data['parameterSettings'] = ['parameterList' => []];
        }

        // process settings
        if (isset($data['parameterSettings'])) {
            $data['parameterSettings'] = new Settings($namespacesPaths, $sanitizeEncoding, $data['parameterSettings'], $companyRegistrationNumber, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    public function getImportRoot(): string
    {
        return 'lst:intParamDetail';
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('ipm:intParamDetail', '', $this->namespace('ipm'));
        $xml->addAttribute('version', '2.0');

        $param = $xml->addChild('ipm:intParam');
        $this->addElements($param, $this->elements, 'ipm');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setRequired('name');
        $resolver->setRequired('parameterType');
        $resolver->setAllowedValues('parameterType', ['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']);
    }
}
