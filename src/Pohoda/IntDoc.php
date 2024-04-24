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

class IntDoc extends Document
{
    /** @var string */
    public static $importRoot = 'lst:intDoc';

    /**
     * Add tax document.
     *
     * @param array<string,mixed> $data
     *
     * @return $this
     */
    public function addTaxDocument(array $data): self
    {
        $this->_data['taxDocument'] = new TaxDocument($data, $this->_ico);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getDocumentElements(): array
    {
        return \array_merge(['taxDocument'], parent::_getDocumentElements());
    }

    /**
     * {@inheritdoc}
     */
    protected function _getDocumentNamespace(): string
    {
        return 'int';
    }

    /**
     * {@inheritdoc}
     */
    protected function _getDocumentName(): string
    {
        return 'intDoc';
    }
}
