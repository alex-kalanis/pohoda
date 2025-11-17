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
 * @property Storage\StorageDto $data
 */
class Storage extends AbstractAgenda
{
    public function getImportRoot(): string
    {
        return 'lst:itemStorage';
    }

    /**
     * Add sub storage.
     *
     * @param self $storage
     *
     * @return $this
     */
    public function addSubStorage(self $storage): self
    {
        $this->data->subStorages[] = $storage;

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
        $storage->addAttribute('code', \strval($this->data->code));

        if (isset($this->data->name)) {
            $storage->addAttribute('name', \strval($this->data->name));
        }

        if (!empty($this->data->subStorages)) {
            $subStorages = $storage->addChild('str:subStorages', '', $this->namespace('str'));

            foreach ($this->data->subStorages as $subStorage) {
                if (\is_a($subStorage, self::class)) {
                    $subStorage->storageXML($subStorages);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Storage\StorageDto();
    }
}
