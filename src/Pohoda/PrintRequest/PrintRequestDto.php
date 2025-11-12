<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Dtos;

class PrintRequestDto extends Dtos\AbstractDto
{
    public Record|RecordDto|null $record = null;
    public PrinterSettings|PrinterSettingsDto|null $printerSettings = null;
}
