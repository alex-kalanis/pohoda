<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\UserList;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class ItemUserCode extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:itemUserCode', '', $this->namespace('lst'));
        $xml->addAttribute('code', strval($this->data['code']));
        $xml->addAttribute('name', strval($this->data['name']));

        if (isset($this->data['constant'])) {
            $xml->addAttribute('constant', strval($this->data['constant']));
        }

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['code', 'name', 'constant']);

        // validate / format options
        $resolver->setRequired('code');
        $resolver->setRequired('name');
        $resolver->setNormalizer('constant', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
    }
}
