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

class Link extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'sourceDocument',
        'settingsSourceDocument',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('typ:link', '', $this->namespace('typ'));

        $this->addElements($xml, $this->getDataElements(), 'typ');

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
        $resolver->setAllowedValues('sourceAgenda', ['issuedInvoice', 'receivedInvoice', 'receivable', 'commitment', 'issuedAdvanceInvoice', 'receivedAdvanceInvoice', 'offer', 'enquiry', 'receivedOrder', 'issuedOrder']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\LinkDto();
    }
}
