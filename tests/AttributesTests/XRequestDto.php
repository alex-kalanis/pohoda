<?php

namespace tests\AttributesTests;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

/**
 * This DTO is only for check request/response types
 */
class XRequestDto extends AbstractDto
{
    #[Attributes\Options\ListRequestTypeOption]
    public ?string $type1 = null;
    #[Attributes\Options\ListRequestTypeOption]
    public ?string $type2 = null;
    #[Attributes\Options\ListRequestTypeOption]
    public ?string $type3 = null;
    #[Attributes\Options\ListRequestTypeOption]
    public ?string $type4 = null;
}
