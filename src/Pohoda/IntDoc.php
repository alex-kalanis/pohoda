<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

use Riesenia\Pohoda\Type\TaxDocument;

class IntDoc extends AbstractDocument
{

    public static string $importRoot = 'lst:intDoc';

    /**
     * Add tax document.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addTaxDocument(array $data): self
    {
        $this->data['taxDocument'] = new TaxDocument($data, $this->ico);

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
