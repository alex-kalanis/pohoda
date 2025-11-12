<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

class UserFilterName extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $filterName = $this->data->userFilterName ?? null;
        return $this->createXML()->addChild(
            'ftr:userFilterName',
            is_null($filterName) ? null : strval($filterName),
            $this->namespace('ftr'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setRequired('userFilterName');
        $resolver->setNormalizer('userFilterName', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string100'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new UserFilterNameDto();
    }
}
