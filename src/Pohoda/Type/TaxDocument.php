<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\Agenda;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Type\SourceLiquidation;

class TaxDocument extends Agenda
{
    /** @var string[] */
    protected $_refElements = [];

    /** @var string[] */
    protected $_elements = ['sourceLiquidation'];

    /**
     * {@inheritdoc}
     */
    public function __construct(array $data, string $ico, bool $resolveOptions = true)
    {
        // process source liquidation
        if (isset($data['sourceLiquidation'])) {
            $data['sourceLiquidation'] = new SourceLiquidation($data['sourceLiquidation'], $ico, $resolveOptions);
        }

        parent::__construct($data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->_createXML()->addChild('int:taxDocument', '', $this->_namespace('int'));

        $this->_addElements($xml, $this->_elements, 'int');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function _configureOptions(OptionsResolver $resolver)
    {
        // available options
        $resolver->setDefined($this->_elements);
    }
}
