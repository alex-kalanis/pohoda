<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property IntDoc\IntDocDto $data
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
     * @param Type\Dtos\TaxDocumentDto $data
     *
     * @return $this
     */
    public function addTaxDocument(Type\Dtos\TaxDocumentDto $data): self
    {
        $taxDocument = new Type\TaxDocument($this->dependenciesFactory);
        $taxDocument
            ->setDirectionalVariable($this->useOneDirectionalVariables)
            ->setResolveOptions($this->resolveOptions)
            ->setData($data);
        $this->data->taxDocument = $taxDocument;

        return $this;
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

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new IntDoc\IntDocDto();
    }
}
