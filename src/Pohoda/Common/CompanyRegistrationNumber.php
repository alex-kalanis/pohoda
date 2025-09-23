<?php

namespace Riesenia\Pohoda\Common;

final class CompanyRegistrationNumber implements CompanyRegistrationNumberInterface
{
    public static function init(string $companyRegistrationNumber): self
    {
        return new self($companyRegistrationNumber);
    }

    public function __construct(
        protected readonly string $companyNumber,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getCompanyNumber(): string
    {
        return $this->companyNumber;
    }
}
