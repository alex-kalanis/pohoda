<?php

namespace Riesenia\Pohoda\Common\Dtos;

use Riesenia\Pohoda\AbstractAgenda;

/**
 * Basic DTO for agenda
 */
class AgendaDto extends AbstractDto
{
    public AbstractHeaderDto|AbstractAgenda|null $header = null;
    public AbstractSummaryDto|AbstractAgenda|null $summary = null;
    /** @var array<AbstractDto|AbstractAgenda> */
    public array $details = [];
}
