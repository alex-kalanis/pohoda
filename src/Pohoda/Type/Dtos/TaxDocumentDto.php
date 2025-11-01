<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;

class TaxDocumentDto extends AbstractDto
{
    public SourceLiquidationDto|Type\SourceLiquidation|null $sourceLiquidation = null;
}
