<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Contract;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type\Address;

/**
 * @property DescDto $data
 */
class Desc extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process partner identity
        if (isset($data->partnerIdentity)) {
            $partnerIdentity = new Address($this->dependenciesFactory);
            $partnerIdentity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->partnerIdentity);
            $data->partnerIdentity = $partnerIdentity;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('con:contractDesc', '', $this->namespace('con'));

        $this->addElements($xml, $this->getDataElements(), 'con');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new DescDto();
    }
}
