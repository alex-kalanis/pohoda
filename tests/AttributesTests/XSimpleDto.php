<?php

namespace tests\AttributesTests;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;

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
    #[Attributes\Options\StringOption(20)]
    public ?string $shortString = null;
    #[Attributes\Options\StringOption(180)]
    public ?string $longString = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $someDate = null;
    #[Attributes\Options\BooleanOption, Attributes\Options\RequiredOption]
    public bool|string|null $someBoolean = null;
    #[Attributes\Options\ListOption(['none', 'high', 'low', 'third'])]
    public ?string $listOfOptions = null;
    #[Attributes\RefElement]
    public ?string $referenceAsString = null;

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
    #[Attributes\Options\IntegerOption, Attributes\ResponseDirection]
    public int|string|null $responseInteger = null;
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
