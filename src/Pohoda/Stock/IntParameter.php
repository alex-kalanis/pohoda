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
use Riesenia\Pohoda\Common;

/**
 * @property IntParameterDto $data
 */
class IntParameter extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:intParameter', '', $this->namespace('stk'));

        $this->addElements($xml, ['intParameterID', 'intParameterType'], 'stk');

        // value
        $value = $this->data->value ?? null;
        $xml->addChild('stk:intParameterValues')
            ->addChild('stk:intParameterValue')
            ->addChild(
                'stk:parameterValue',
                is_null($value) ? null : strval($value),
            );

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setRequired('intParameterID');
        $resolver->setNormalizer('intParameterID', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setRequired('intParameterType');
        $resolver->setAllowedValues('intParameterType', ['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']);
        $resolver->setRequired('value');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new IntParameterDto();
    }
}
