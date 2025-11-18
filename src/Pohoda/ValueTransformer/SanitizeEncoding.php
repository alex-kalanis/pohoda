<?php

namespace kalanis\Pohoda\ValueTransformer;

final class SanitizeEncoding
{
    protected string $encoding = 'windows-1250';
    protected bool $sanitizeEncoding = false;

    public function __construct(
        protected readonly Listing $listing,
    ) {}

    public function listingWithEncoding(): void
    {
        if ($this->sanitizeEncoding) {
            $this->listing->addTransformer(new EncodingTransformer('utf-8', $this->encoding . '//translit'));
            $this->listing->addTransformer(new EncodingTransformer($this->encoding, 'utf-8'));
        }
    }

    public function willBeSanitized(bool $sanitizeEncoding): void
    {
        $this->sanitizeEncoding = $sanitizeEncoding;
    }

    public function getListing(): Listing
    {
        return $this->listing;
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }
}
