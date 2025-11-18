<?php

declare(strict_types=1);

namespace kalanis\Pohoda\AddressBook;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type\Address;

/**
 * @property HeaderDto $data
 */
class Header extends AbstractAgenda
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process identity
        if (isset($data->identity)) {
            $identity = new Address($this->dependenciesFactory);
            $identity
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->identity);
            $data->identity = $identity;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('adb:addressbookHeader', '', $this->namespace('adb'));

        $this->addElements($xml, $this->getDataElements(), 'adb');

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
