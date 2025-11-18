<?php

declare(strict_types=1);

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property RecordDto $data
 */
class Record extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        if (!empty($data->filter)) {
            // process filter
            $filter = new Filter($this->dependenciesFactory);
            $filter
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->filter);
            $data->filter = $filter;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('prn:record', '', $this->namespace('prn'));
        $xml->addAttribute('agenda', strval($this->data->agenda));

        $this->addElements($xml, $this->getDataElements(), 'prn');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new RecordDto();
    }
}
