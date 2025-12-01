<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class PrintRequestSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $recordFilter = new Pohoda\PrintRequest\FilterDto();
        $recordFilter->id = 1234; // ID of list in Pohoda;

        $record = new Pohoda\PrintRequest\RecordDto();
        $record->agenda = 'vydane_faktury';
        $record->filter = $recordFilter;

        $report = new Pohoda\PrintRequest\ReportDto();
        $report->id = 5678;

        $pdf = new Pohoda\PrintRequest\PdfDto();
        $pdf->fileName = 'C:\Test\1234.pdf';

        $settings = new Pohoda\PrintRequest\PrinterSettingsDto();
        $settings->report = $report;
        $settings->pdf = $pdf;

        $dto = new Pohoda\PrintRequest\PrintRequestDto();
        $dto->printerSettings = $settings;
        $dto->record = $record;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType(Pohoda\PrintRequest::class);
        $this->shouldHaveType(Pohoda\AbstractAgenda::class);
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<prn:print version="1.0"><prn:record agenda="vydane_faktury"><ftr:filter><ftr:id>1234</ftr:id></ftr:filter></prn:record><prn:printerSettings><prn:report><prn:id>5678</prn:id></prn:report><prn:pdf><prn:fileName>C:\Test\1234.pdf</prn:fileName></prn:pdf></prn:printerSettings></prn:print>');
    }
}
