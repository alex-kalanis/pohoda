<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;

class PrintRequestTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\PrintRequest::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertNull($lib->getImportRoot());
    }

    public function testCreateCorrectXmlPdf(): void
    {
        $this->assertEquals('<prn:print version="1.0"><prn:record agenda="vydane_faktury"><ftr:filter><ftr:id>1234</ftr:id></ftr:filter></prn:record><prn:printerSettings><prn:report><prn:id>5678</prn:id></prn:report><prn:pdf><prn:fileName>C:\Test\1234.pdf</prn:fileName></prn:pdf><prn:parameters><prn:copy>3</prn:copy><prn:datePrint>123-src-456-tgt-789</prn:datePrint><prn:checkbox1><prn:value>true</prn:value></prn:checkbox1><prn:checkbox2><prn:value>true</prn:value></prn:checkbox2><prn:checkbox3><prn:value>true</prn:value></prn:checkbox3><prn:checkbox4><prn:value>true</prn:value></prn:checkbox4><prn:checkbox5><prn:value>true</prn:value></prn:checkbox5><prn:checkbox6><prn:value>true</prn:value></prn:checkbox6><prn:checkbox7><prn:value>true</prn:value></prn:checkbox7><prn:radioButton1><prn:value>0</prn:value></prn:radioButton1><prn:spin1><prn:value>123</prn:value></prn:spin1><prn:currency1><prn:value>153</prn:value></prn:currency1><prn:month1><prn:value>9</prn:value></prn:month1><prn:month2><prn:value>11</prn:value></prn:month2><prn:year1><prn:value>1990</prn:value></prn:year1><prn:date1/><prn:date2><prn:value>2021-11-26</prn:value></prn:date2><prn:date3><prn:value>2017-08-31</prn:value></prn:date3><prn:date4><prn:value>2017-08-31</prn:value></prn:date4><prn:text1><prn:value>bar</prn:value></prn:text1><prn:text2><prn:value>baz</prn:value></prn:text2><prn:text3><prn:value>faz</prn:value></prn:text3><prn:combobox1><prn:value>okm</prn:value></prn:combobox1><prn:combobox2><prn:value>ijn</prn:value></prn:combobox2><prn:combobox3><prn:value>uhb</prn:value></prn:combobox3><prn:comboboxEx1><prn:value>zgv</prn:value></prn:comboboxEx1><prn:comboboxEx2><prn:value>tfc</prn:value></prn:comboboxEx2></prn:parameters></prn:printerSettings></prn:print>', $this->getLib()->getXML()->asXML());
    }

    public function testKnownPdfData(): void
    {
        $recordFilter = new Pohoda\PrintRequest\FilterDto();
        $recordFilter->id = 463; // ID of list in Pohoda;

        $record = new Pohoda\PrintRequest\RecordDto();
        $record->agenda = 'vydane_faktury';
        $record->filter = $recordFilter;

        $report = new Pohoda\PrintRequest\ReportDto();
        $report->id = 111; // ID of printing base

        $pdf = new Pohoda\PrintRequest\PdfDto();
        $pdf->fileName = 'Z:\\\\Pohoda_Export\\Dokumenty_PDF\\\\receipts-123456789.pdf'; // usually returns just simple backslashes - for escaping it's necessary to double it twice

        $params = new Pohoda\PrintRequest\ParametersDto();
        $params->checkbox1 = Pohoda\PrintRequest\ParameterDto::init(false);
        $params->checkbox2 = Pohoda\PrintRequest\ParameterDto::init(false);
        $params->checkbox5 = Pohoda\PrintRequest\ParameterDto::init(false);
        $params->checkbox6 = Pohoda\PrintRequest\ParameterDto::init(false);
        $params->checkbox8 = Pohoda\PrintRequest\ParameterDto::init(true);
        $params->checkbox10 = Pohoda\PrintRequest\ParameterDto::init(true); // unknown in factory, will be kicked out

        $settings = new Pohoda\PrintRequest\PrinterSettingsDto();
        $settings->report = $report;
        $settings->pdf = $pdf;
        $settings->parameters = $params;

        $dto = new Pohoda\PrintRequest\PrintRequestDto();
        $dto->printerSettings = $settings;
        $dto->record = $record;

        $lib = new Pohoda\PrintRequest($this->getBasicDi());
        $lib->setData($dto);
        $this->assertEquals('<prn:print version="1.0"><prn:record agenda="vydane_faktury"><ftr:filter><ftr:id>463</ftr:id></ftr:filter></prn:record><prn:printerSettings><prn:report><prn:id>111</prn:id></prn:report><prn:pdf><prn:fileName>Z:\\\\Pohoda_Export\Dokumenty_PDF\\\\receipts-123456789.pdf</prn:fileName></prn:pdf><prn:parameters><prn:checkbox1><prn:value>false</prn:value></prn:checkbox1><prn:checkbox2><prn:value>false</prn:value></prn:checkbox2><prn:checkbox5><prn:value>false</prn:value></prn:checkbox5><prn:checkbox6><prn:value>false</prn:value></prn:checkbox6><prn:checkbox8><prn:value>true</prn:value></prn:checkbox8></prn:parameters></prn:printerSettings></prn:print>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\PrintRequest
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

        $params = new Pohoda\PrintRequest\ParametersDto();
        $params->copy = 3;
        $params->datePrint = '123-src-456-tgt-789';
        $params->checkbox1 = Pohoda\PrintRequest\ParameterDto::init('foo');
        $params->checkbox2 = Pohoda\PrintRequest\ParameterDto::init('qya');
        $params->checkbox3 = Pohoda\PrintRequest\ParameterDto::init('wsx');
        $params->checkbox4 = Pohoda\PrintRequest\ParameterDto::init('edc');
        $params->checkbox5 = Pohoda\PrintRequest\ParameterDto::init('rfv');
        $params->checkbox6 = Pohoda\PrintRequest\ParameterDto::init('tgb');
        $params->checkbox7 = Pohoda\PrintRequest\ParameterDto::init('zhn');
        $params->radioButton1 = Pohoda\PrintRequest\ParameterDto::init('ujm');
        $params->spin1 = Pohoda\PrintRequest\ParameterDto::init(123);
        $params->currency1 = Pohoda\PrintRequest\ParameterDto::init(153);
        $params->month1 = Pohoda\PrintRequest\ParameterDto::init(9);
        $params->month2 = Pohoda\PrintRequest\ParameterDto::init(11);
        $params->year1 = Pohoda\PrintRequest\ParameterDto::init(1990);
        $params->date1 = Pohoda\PrintRequest\ParameterDto::init(null); // intentionally empty
        $params->date2 = Pohoda\PrintRequest\ParameterDto::init(new \DateTime('2021-11-26 19:32:24'));
        $params->date3 = Pohoda\PrintRequest\ParameterDto::init('2017-08-31 02:48:35');
        $params->date4 = Pohoda\PrintRequest\ParameterDto::init('2017-08-31 02:48:35');
        $params->text1 = Pohoda\PrintRequest\ParameterDto::init('bar');
        $params->text2 = Pohoda\PrintRequest\ParameterDto::init('baz');
        $params->text3 = Pohoda\PrintRequest\ParameterDto::init('faz');
        $params->combobox1 = Pohoda\PrintRequest\ParameterDto::init('okm');
        $params->combobox2 = Pohoda\PrintRequest\ParameterDto::init('ijn');
        $params->combobox3 = Pohoda\PrintRequest\ParameterDto::init('uhb');
        $params->comboboxEx1 = Pohoda\PrintRequest\ParameterDto::init('zgv');
        $params->comboboxEx2 = Pohoda\PrintRequest\ParameterDto::init('tfc');

        $settings = new Pohoda\PrintRequest\PrinterSettingsDto();
        $settings->report = $report;
        $settings->pdf = $pdf;
        $settings->parameters = $params;

        $dto = new Pohoda\PrintRequest\PrintRequestDto();
        $dto->printerSettings = $settings;
        $dto->record = $record;

        $lib = new Pohoda\PrintRequest($this->getBasicDi());
        return $lib->setData($dto);
    }
}
