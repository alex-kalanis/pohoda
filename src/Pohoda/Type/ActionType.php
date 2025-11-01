<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

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
            throw new \LogicException('Namespace not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':actionType', '', $this->namespace($this->namespace));
        $action = $xml->addChild($this->namespace . ':' . ('add/update' == $this->data->type ? 'add' : $this->data->type));

        if ('add/update' == $this->data->type) {
            $action->addAttribute('update', 'true');
        }

        if (!is_null($this->data->filter)) {
            $filter = $action->addChild('ftr:filter', '', $this->namespace('ftr'));

            if (!empty($this->data->agenda)) {
                $filter->addAttribute('agenda', strval($this->data->agenda));
            }

            foreach ($this->data->filter as $property => $value) {
                $ftr = $filter->addChild('ftr:' . $property, \is_array($value) ? null : strval($value));

                if (\is_array($value)) {
                    foreach ($value as $tProperty => $tValue) {
                        $ftr->addChild('typ:' . $tProperty, $tValue, $this->namespace('typ'));
                    }
                }
            }
        }

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
        $resolver->setRequired('type');
        $resolver->setAllowedValues('type', ['add', 'add/update', 'update', 'delete']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\ActionTypeDto();
    }
}
