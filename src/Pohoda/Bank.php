<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

class Bank extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:bank';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'bnk';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'bank';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Bank\BankDto();
    }
}
