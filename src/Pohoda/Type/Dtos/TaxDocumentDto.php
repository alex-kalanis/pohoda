<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type;

class TaxDocumentDto extends AbstractDto
{
    public SourceLiquidationDto|Type\SourceLiquidation|null $sourceLiquidation = null;
}
