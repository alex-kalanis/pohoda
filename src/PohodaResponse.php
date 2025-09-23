<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia;

use Riesenia\Pohoda\AbstractAgenda;

/**
 * Factory for Pohoda objects.
 */
class PohodaResponse extends Pohoda
{
    /**
     * Open new XML file for writing.
     *
     * @param string|null $filename path to output file or null for memory
     * @param string      $id
     * @param string      $note
     * @param string      $state
     * @param string|null $programVersion
     * @param string|null $key
     *
     * @return bool
     */
    public function open(?string $filename, string $id, string $note = '', string $state = 'ok', ?string $programVersion = null, ?string $key = null): bool
    {
        $this->xmlWriter = new \XMLWriter();

        if (is_null($filename)) {
            $this->isInMemory = true;
            $this->xmlWriter->openMemory();
        } else {
            $this->isInMemory = false;

            if (!$this->xmlWriter->openUri($filename)) {
                // @codeCoverageIgnoreStart
                // I cannot test this, because it needs source file somewhere online
                return false;
            }
            // @codeCoverageIgnoreEnd
        }

        $this->xmlWriter->startDocument('1.0', $this->sanitizeEncoding->getEncoding());
        $this->xmlWriter->startElementNs('rsp', 'responsePack', null);

        $this->xmlWriter->writeAttribute('id', $id);
        $this->xmlWriter->writeAttribute('ico', $this->companyRegistrationNumber->getCompanyNumber());
        $this->xmlWriter->writeAttribute('version', '2.0');
        $this->xmlWriter->writeAttribute('note', $note);
        $this->xmlWriter->writeAttribute('state', $state);
        if (!is_null($programVersion)) {
            $this->xmlWriter->writeAttribute('programVersion', $programVersion);
        }
        if (!is_null($key)) {
            $this->xmlWriter->writeAttribute('key', $key);
        }

        foreach ($this->namespacesPaths->allNamespaces() as $k => $v) {
            // put all known namespaces into base element attributes
            $this->xmlWriter->writeAttributeNs('xmlns', $k, null, $v);
        }

        return true;
    }

    /**
     * Add item.
     *
     * @param string $id
     * @param AbstractAgenda $agenda
     * @param array<string, mixed> $data deprecated
     * @param string $state
     *
     * @return void
     */
    public function addItem(string $id, AbstractAgenda $agenda, array $data = [], string $state = 'ok'): void
    {
        $this->xmlWriter->startElementNs('rsp', 'responsePackItem', null);

        $this->xmlWriter->writeAttribute('id', $id);
        $this->xmlWriter->writeAttribute('version', '2.0');
        $this->xmlWriter->writeAttribute('state', $state);
        $this->xmlWriter->writeRaw((string) $agenda->getXML()->asXML());
        $this->xmlWriter->endElement();

        if (!$this->isInMemory) {
            $this->xmlWriter->flush();
        }
    }
}
