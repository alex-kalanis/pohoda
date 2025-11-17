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

class Parameter extends AbstractAgenda
{
    /** @var string */
    protected string $valueType = 'string';

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $reflect = new \ReflectionClass($this);
        $classname = $reflect->getShortName();
        $xml = $this->createXML()->addChild('prn:'.lcfirst($classname), '', $this->namespace('prn'));

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return ParameterDto::init(null, $this->valueType);
    }
}
