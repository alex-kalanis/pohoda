<?php

namespace kalanis\Pohoda\Common\Dtos;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type;

/**
 * Basic DTO for headers
 */
abstract class AbstractHeaderDto extends AbstractDto
{
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    #[Common\Attributes\OnlyInternal]
    public array $parameters = [];
}
