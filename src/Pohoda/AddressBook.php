<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property AddressBook\AddressBookDto $data
 */
class AddressBook extends AbstractAgenda
{
    use Common\AddActionTypeTrait;
    use Common\AddParameterToHeaderTrait;

    public function getImportRoot(): string
    {
        return 'lAdb:addressbook';
    }

    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // pass to header
        if (!empty($data->header)) {
            $header = new AddressBook\Header($this->dependenciesFactory);
            $header
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->header);
            $data->header = $header;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('adb:addressbook', '', $this->namespace('adb'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, $this->getDataElements(), 'adb');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new AddressBook\AddressBookDto();
    }
}
