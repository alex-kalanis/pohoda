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
 * @property array{
 *     taxDocument?: Type\TaxDocument,
 * } $data
 */
class IntDoc extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:intDoc';
    }

    /**
     * Add tax document.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addTaxDocument(array $data): self
    {
        $taxDocument = new Type\TaxDocument($this->dependenciesFactory);
        $taxDocument->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data);
        $this->data['taxDocument'] = $taxDocument;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentElements(): array
    {
        return \array_merge(['taxDocument'], parent::getDocumentElements());
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'int';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'intDoc';
    }
}
