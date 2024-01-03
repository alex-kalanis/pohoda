<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Agenda;
use Riesenia\Pohoda\Common\OptionsResolver;

class Parameter extends Agenda
{
    /** @var string */
    protected $valueType = 'string';

    /** @var string[] */
    protected $_elements = ['value'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $reflect = new \ReflectionClass($this);
        $classname = $reflect->getShortName();
        $xml = $this->_createXML()->addChild('prn:'.lcfirst($classname), '', $this->_namespace('prn'));

        $this->_addElements($xml, $this->_elements, 'prn');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function _configureOptions(OptionsResolver $resolver)
    {
        // available options
        $resolver->setDefined($this->_elements);

        // validate / format options
        $resolver->setNormalizer('value', $resolver->getNormalizer($this->valueType));
    }
}
