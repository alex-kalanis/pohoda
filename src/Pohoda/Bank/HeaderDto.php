<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\Options\ListOption(['receipt', 'expense'])]
    public ?string $bankType = null;
    #[Attributes\RefElement]
    public ?string $account = null;
    public StatementNumberDto|StatementNumber|null $statementNumber = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symVar = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateStatement = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $datePayment = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    #[Attributes\Options\StringOption(96)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    /** @var array<string, string|int|float>|string|null */
    #[Attributes\RefElement]
    public array|string|null $paymentAccount = null;
    #[Attributes\Options\StringOption(4)]
    public ?string $symConst = null;
    #[Attributes\Options\StringOption(16)]
    public ?string $symSpec = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\RefElement]
    public ?string $MOSS = null;
    #[Attributes\RefElement]
    public ?string $evidentiaryResourcesMOSS = null;
    #[Attributes\Options\StringOption(7)]
    public ?string $accountingPeriodMOSS = null;
    public ?string $note = null;
    public ?string $intNote = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
