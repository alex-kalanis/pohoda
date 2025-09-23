<?php

namespace Riesenia\Pohoda\Common;

interface CompanyRegistrationNumberInterface
{
    /**
     * Current company number which will be used for generating XML
     * @return string
     */
    public function getCompanyNumber(): string;
}
