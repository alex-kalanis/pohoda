<?php

namespace tests\AttributesTests;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

/**
 * This DTO is only for check extending params
 */
class XExtendDto extends AbstractDto
{
    public ?string $basicVariable = null;
    public ?string $anotherVariable = null;
    #[Attributes\AttributeExtend('basicVariable', 'attr1')]
    public ?string $dummyName1 = null;
    #[Attributes\AttributeExtend('basicVariable', 'attr2'), Attributes\Options\IntegerOption]
    public int|string|null $dummyName2 = null;
    #[Attributes\AttributeExtend('anotherVariable', 'other'), Attributes\ResponseDirection]
    public ?string $dummyName3 = null;
}
