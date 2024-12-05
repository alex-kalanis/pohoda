<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\IntParam\Settings;

class IntParam extends AbstractAgenda
{

    public static string $importRoot = 'lst:intParamDetail';

    /** @var string[] */
    protected array $elements = ['name', 'description', 'parameterType', 'parameterSettings'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // prepare empty parameter list for list
        if ('listValue' == $data['parameterType']) {
            $data['parameterSettings'] = ['parameterList' => []];
        }

        // process settings
        if (isset($data['parameterSettings'])) {
            $data['parameterSettings'] = new Settings($data['parameterSettings'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
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
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setRequired('name');
        $resolver->setRequired('parameterType');
        $resolver->setAllowedValues('parameterType', ['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']);
    }
}
