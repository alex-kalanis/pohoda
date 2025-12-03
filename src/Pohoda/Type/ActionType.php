<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;
use kalanis\PohodaException;

/**
 * @property Dtos\ActionTypeDto $data
 */
class ActionType extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new PohodaException('Namespace not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':actionType', '', $this->namespace($this->namespace));
        $action = $xml->addChild($this->namespace . ':' . (
            Enums\ActionTypeEnum::AddUpdate->value == $this->data->type
                ? Enums\ActionTypeEnum::Add->value
                : \strval($this->data->type)
        ));

        if (Enums\ActionTypeEnum::AddUpdate->value == $this->data->type) {
            $action->addAttribute(Enums\ActionTypeEnum::Update->value, 'true');
        }

        if (!empty($this->data->filter)) {
            $filter = $action->addChild('ftr:filter', '', $this->namespace('ftr'));

            if (!empty($this->data->agenda)) {
                $filter->addAttribute('agenda', strval($this->data->agenda));
            }

            foreach ($this->data->filter as $property => $value) {
                $ftr = $filter->addChild('ftr:' . $property, \is_array($value) ? null : \strval($value));

                if (\is_array($value)) {
                    foreach ($value as $tProperty => $tValue) {
                        $ftr->addChild('typ:' . $tProperty, \strval($tValue), $this->namespace('typ'));
                    }
                }
            }
        }

        return $xml;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\ActionTypeDto();
    }
}
