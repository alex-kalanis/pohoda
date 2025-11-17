<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class LinkDto extends AbstractDto
{
    #[Attributes\Options\ListOption(['issuedInvoice', 'receivedInvoice', 'receivable', 'commitment', 'issuedAdvanceInvoice', 'receivedAdvanceInvoice', 'offer', 'enquiry', 'receivedOrder', 'issuedOrder'])]
    public ?string $sourceAgenda = null;
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $sourceDocument = null;
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $settingsSourceDocument = null;
}
