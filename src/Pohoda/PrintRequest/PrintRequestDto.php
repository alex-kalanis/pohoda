<?php

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class PrintRequestDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public Record|RecordDto|null $record = null;
    #[Attributes\Options\RequiredOption]
    public PrinterSettings|PrinterSettingsDto|null $printerSettings = null;
}
