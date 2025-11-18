<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

/**
 * @property Offer\OfferDto $data
 */
class Offer extends AbstractDocument
{
    public function getImportRoot(): string
    {
        return 'lst:offer';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentNamespace(): string
    {
        return 'ofr';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDocumentName(): string
    {
        return 'offer';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Offer\OfferDto();
    }
}
