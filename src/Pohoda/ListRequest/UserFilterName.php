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
use Riesenia\Pohoda\Common\OptionsResolver;

class UserFilterName extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $filterName = $this->data['userFilterName'] ?? null;
        return $this->createXML()->addChild(
            'ftr:userFilterName',
            is_null($filterName) ? null : strval($filterName),
            $this->namespace('ftr'),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['userFilterName']);

        // validate / format options
        $resolver->setRequired('userFilterName');
        $resolver->setNormalizer('userFilterName', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string100'));
    }
}
