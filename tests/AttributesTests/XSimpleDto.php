<?php

namespace tests\AttributesTests;

use AllowDynamicProperties;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Common\Enums;
use kalanis\Pohoda\Type;

/**
 * This DTO is only synthesis of necessities for tests
 * For testing purposes of Parameters it allows dynamically added properties
 */
#[AllowDynamicProperties]
class XSimpleDto extends AbstractDto
{
    // simple ones
    public ?string $withoutAttributes = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $integer = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $float = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $shortString = null;
    #[Attributes\Options\StringOption(180)]
    public ?string $longString = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $someDate = null;
    #[Attributes\Options\BooleanOption(null, true)]
    public bool|string|null $someBoolean = null;
    #[Attributes\Options\ListOption(['none', 'high', 'low', 'third'])]
    public ?string $listOfOptions = null;
    #[Attributes\Options\ListOption(['none', 'high', 'low', 'third']), Attributes\Options\DefaultOption('low')]
    public ?string $listOfOptionsWithDefault = null;
    #[Attributes\Options\EnumOption(Enums\RateVatEnum::class), Attributes\Options\DefaultOption(Enums\RateVatEnum::Third)]
    public Enums\RateVatEnum|string|null $listOfEnumsWithDefault = null;
    #[Attributes\RefElement]
    public ?string $referenceAsString = null;

    // attributes to existing elements
    #[Attributes\AttributeExtend('longString', 'avail', 'fnk')]
    public ?string $attr1 = null;

    // required ones
    #[Attributes\Options\IntegerOption, Attributes\Options\RequiredOption]
    public int|string|null $requiredInteger = null;
    #[Attributes\Options\BooleanOption, Attributes\Options\RequiredOption]
    public bool|string|null $requiredBoolean = null;

    // limited ones
    #[Attributes\OnlyInternal]
    public int|string|null $internal = null;
    #[Attributes\JustAttribute]
    public int|string|null $justAttribute = null;

    // combined ones - response direction
    #[Attributes\Options\IntegerOption(null, true), Attributes\ResponseDirection]
    public int|string|null $responseInteger = null;
    #[Attributes\Options\FloatOption(null, true), Attributes\ResponseDirection]
    public int|string|null $responseFloat = null;
    #[Attributes\Options\DateTimeOption(null, true), Attributes\ResponseDirection]
    public \DateTimeInterface|string|null $responseDate = null;
    #[Attributes\Options\TimeOption(null, true), Attributes\ResponseDirection]
    public \DateTimeInterface|string|null $responseTime = null;
    #[Attributes\RefElement, Attributes\ResponseDirection]
    public ?string $referencedResponse = null;

    // sub-dtos
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $currency = null;

    // special - redirection to different property; must be typed as parent of this one
    #[Attributes\Represents('willBeSkipped')]
    public int|string|null $redirectToDifferentOne = null;
    #[Attributes\OnlyInternal]
    public int|string|null $willBeSkipped = null;

    #[Attributes\Represents(['willBeSkipped2', 'willBeSkipped3'])]
    public int|string|null $redirectToMultipleDifferent = null;
    #[Attributes\OnlyInternal]
    public int|string|null $willBeSkipped2 = null;
    #[Attributes\OnlyInternal]
    public int|string|null $willBeSkipped3 = null;
}
