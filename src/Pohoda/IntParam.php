<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property IntParam\IntParamDto $data
 */
class IntParam extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process settings
        if (isset($data->parameterSettings)) {
            // prepare empty parameter list for list
            if (!empty($data->parameterType) && (Common\Enums\ParamTypeEnum::ListValue->value == $data->parameterType)) {
                if (!isset($data->parameterSettings->parameterList)) {
                    $data->parameterSettings->parameterList = [];
                }
            }

            $parameterSettings = new IntParam\Settings($this->dependenciesFactory);
            $parameterSettings
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->parameterSettings);
            $data->parameterSettings = $parameterSettings;
        }

        return parent::setData($data);
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
        $this->addElements($param, $this->getDataElements(), 'ipm');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new IntParam\IntParamDto();
    }
}
