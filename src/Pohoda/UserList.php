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
 * Definition of user-defined list
 *
 * @property UserList\UserListDto $data
 */
class UserList extends AbstractAgenda
{
    public function getImportRoot(): string
    {
        return 'lst:listUserCode';
    }

    /**
     * Add item user code.
     *
     * @param UserList\ItemUserCodeDto $data
     *
     * @return $this
     */
    public function addItemUserCode(UserList\ItemUserCodeDto $data): self
    {
        $itemUserCodes = new UserList\ItemUserCode($this->dependenciesFactory);
        $itemUserCodes
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->itemUserCodes[] = $itemUserCodes;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('lst:listUserCode', '', $this->namespace('lst'));
        $xml->addAttribute('version', '1.1');
        $xml->addAttribute('code', strval($this->data->code));
        $xml->addAttribute('name', strval($this->data->name));

        if (isset($this->data->dateTimeStamp)) {
            $xml->addAttribute('dateTimeStamp', $this->data->dateTimeStamp);
        }

        if (isset($this->data->dateValidFrom)) {
            $xml->addAttribute('dateValidFrom', $this->data->dateValidFrom);
        }

        if (isset($this->data->submenu)) {
            $xml->addAttribute('submenu', strval($this->data->submenu));
        }

        if (isset($this->data->constants) && 'true' == $this->data->constants) {
            $xml->addAttribute('constants', strval($this->data->constants));
        }

        if (!empty($this->data->itemUserCodes)) {
            foreach ($this->data->itemUserCodes as $itemUserCode) {
                $this->appendNode($xml, $itemUserCode->getXML());
            }
        }

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
        $resolver->setRequired('code');
        $resolver->setRequired('name');
        $resolver->setNormalizer('constants', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('dateTimeStamp', $this->dependenciesFactory->getNormalizerFactory()->getClosure('datetime'));
        $resolver->setNormalizer('dateValidFrom', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('submenu', $this->dependenciesFactory->getNormalizerFactory()->getClosure('boolean'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new UserList\UserListDto();
    }

    /**
     * {@inheritdoc}
     */
    protected function skipElements(): array
    {
        return ['itemUserCodes'];
    }
}
