<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Dtos;

class PrinterSettingsDto extends Dtos\AbstractDto
{
    public Report|ReportDto|null $report = null;
    public ?string $printer = null;
    public Pdf|PdfDto|null $pdf = null;
    public Parameters|ParametersDto|null $parameters = null;
}
