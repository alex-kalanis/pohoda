<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Common\OptionsResolver;

class Storage extends AbstractAgenda
{

    public function getImportRoot(): string
    {
        return 'lst:itemStorage';
    }

    /**
     * Add substorage.
     *
     * @param self $storage
     *
     * @return $this
     */
    public function addSubstorage(self $storage): self
    {
        if (!isset($this->data['subStorages'])
            || !(
                is_array($this->data['subStorages'])
                || (is_object($this->data['subStorages']) && is_a($this->data['subStorages'], \ArrayAccess::class))
            )
        ) {
            $this->data['subStorages'] = [];
        }

        $this->data['subStorages'][] = $storage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('str:storage', '', $this->namespace('str'));
        $xml->addAttribute('version', '2.0');

        $this->storageXML($xml);

        return $xml;
    }

    /**
     * Attach storage to XML element.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return void
     */
    public function storageXML(\SimpleXMLElement $xml): void
    {
        $storage = $xml->addChild('str:itemStorage', '', $this->namespace('str'));
        $storage->addAttribute('code', strval($this->data['code']));

        if (isset($this->data['name'])) {
            $storage->addAttribute('name', strval($this->data['name']));
        }

        if (isset($this->data['subStorages']) && is_iterable($this->data['subStorages'])) {
            $subStorages = $storage->addChild('str:subStorages', '', $this->namespace('str'));

            foreach ($this->data['subStorages'] as $subStorage) {
                /** @var self $subStorage */
                $subStorage->storageXML($subStorages);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['code', 'name']);

        // validate / format options
        $resolver->setRequired('code');
    }
}
