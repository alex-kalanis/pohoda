<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class PrintRequestDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public Record|RecordDto|null $record = null;
    #[Attributes\Options\RequiredOption]
    public PrinterSettings|PrinterSettingsDto|null $printerSettings = null;
}
