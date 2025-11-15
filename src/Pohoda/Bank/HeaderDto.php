<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public ?string $bankType = null;
    #[Attributes\RefElement]
    public ?string $account = null;
    public StatementNumberDto|StatementNumber|null $statementNumber = null;
    public ?string $symVar = null;
    public \DateTimeInterface|string|null $dateStatement = null;
    public \DateTimeInterface|string|null $datePayment = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\RefElement]
    public array|string|null $paymentAccount = null;
    public ?string $symConst = null;
    public ?string $symSpec = null;
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\RefElement]
    public ?string $MOSS = null;
    #[Attributes\RefElement]
    public ?string $evidentiaryResourcesMOSS = null;
    public ?string $accountingPeriodMOSS = null;
    public ?string $note = null;
    public ?string $intNote = null;
    public \ArrayAccess|array $parameters = [];
}
