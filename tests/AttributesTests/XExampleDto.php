<?php

namespace tests\AttributesTests;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type;

/**
 * This DTO contains most of the available attributes and options
 */
class XExampleDto extends AbstractDto
{
    // simple ones
    public ?string $withoutAttributes = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $integer = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $float = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $shortString = null;
    #[Attributes\Options\StringOption(180)]
    public ?string $longString = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $someDate = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $someBoolean = null;
    #[Attributes\Options\ListOption(['none', 'high', 'low', 'third'])]
    public ?string $listOfOptions = null;
    #[Attributes\RefElement]
    public ?string $referenceAsString = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $referenceAsArray = null;

    // limited ones
    #[Attributes\OnlyInternal]
    public float|string|null $internal = null;
    #[Attributes\JustAttribute]
    public float|string|null $justAttribute = null;

    // attributes to existing elements
    #[Attributes\AttributeExtend('longString', 'avail', 'other')]
    public ?string $attr1 = null;

    // combined ones - response direction
    #[Attributes\Options\IntegerOption, Attributes\ResponseDirection]
    public int|string|null $responseInteger = null;
    #[Attributes\RefElement, Attributes\ResponseDirection]
    public ?string $referencedResponse = null;

    // sub-dtos
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $currency = null;

    // special - redirection to different property
    #[Attributes\Represents('willBeSkipped')]
    public float|string|null $redirectToDifferentOne = null;
    #[Attributes\OnlyInternal]
    public float|string|null $willBeSkipped = null;

    // extra without specification
    public array $parameters = [];
}
