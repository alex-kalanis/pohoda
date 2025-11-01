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

class Record extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process filter
        $filter = new Filter($this->dependenciesFactory);
        $filter
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data['filter']);
        $data['filter'] = $filter;

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:record', '', $this->namespace('prn'));
        $xml->addAttribute('agenda', strval($this->data['agenda']));

        $this->addElements($xml, ['filter'], 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['agenda', 'filter']);

        $resolver->setRequired('agenda');
        $resolver->setRequired('filter');
    }
}
