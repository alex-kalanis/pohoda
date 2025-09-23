<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

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
        $lib = new Pohoda\PrintRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        $lib->setData([
            'record' => [
                'agenda' => 'vydane_faktury',
                'filter' => [
                    'id' => 463, //ID dokladu v Pohoda
                ],
            ],
            'printerSettings' => [
                'pdf' => [
                    'fileName' => 'Z:\\\\Pohoda_Export\\Dokumenty_PDF\\\\receipts-123456789.pdf', // bezne vrati jenom jednoducha zpetna lomitka - pro escape je potreba zdvojit jeste jednou
                ],
                'report' => [
                    'id' => 111, //ID tiskové sestavy
                ],
                'parameters' => [ // Zobrazovat nebo nezobrazovat různé součásti tiskového PDF, např. DPH, QR kód...
                    'checkbox1' => [
                        'value' => false,
                    ],
                    'checkbox2' => [
                        'value' => false,
                    ],
                    'checkbox5' => [
                        'value' => false,
                    ],
                    'checkbox6' => [
                        'value' => false,
                    ],
                    'checkbox8' => [
                        'value' => true,
                    ],
                ],
            ],
        ]);
        $this->assertEquals('<prn:print version="1.0"><prn:record agenda="vydane_faktury"><ftr:filter><ftr:id>463</ftr:id></ftr:filter></prn:record><prn:printerSettings><prn:report><prn:id>111</prn:id></prn:report><prn:pdf><prn:fileName>Z:\\\\Pohoda_Export\Dokumenty_PDF\\\\receipts-123456789.pdf</prn:fileName></prn:pdf><prn:parameters><prn:checkbox1><prn:value>false</prn:value></prn:checkbox1><prn:checkbox2><prn:value>false</prn:value></prn:checkbox2><prn:checkbox5><prn:value>false</prn:value></prn:checkbox5><prn:checkbox6><prn:value>false</prn:value></prn:checkbox6><prn:checkbox8><prn:value>true</prn:value></prn:checkbox8></prn:parameters></prn:printerSettings></prn:print>', $lib->getXML()->asXML());
    }

    protected function getLib(): Pohoda\PrintRequest
    {
        $lib = new Pohoda\PrintRequest(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()));
        return $lib->setData([
            'record' => [
                'agenda' => 'vydane_faktury',
                'filter' => [
                    'id' => '1234',
                ],
            ],
            'printerSettings' => [
                'report' => [
                    'id' => 5678,
                ],
                'pdf' => [
                    'fileName' => 'C:\Test\1234.pdf',
                ],
                // this is not usually need...
                'parameters' => [
                    'copy' => 3,
                    'datePrint' => '123-src-456-tgt-789',
                    'checkbox1' => [
                        'value' => 'foo',
                    ],
                    'checkbox2' => [
                        'value' => 'qya',
                    ],
                    'checkbox3' => [
                        'value' => 'wsx',
                    ],
                    'checkbox4' => [
                        'value' => 'edc',
                    ],
                    'checkbox5' => [
                        'value' => 'rfv',
                    ],
                    'checkbox6' => [
                        'value' => 'tgb',
                    ],
                    'checkbox7' => [
                        'value' => 'zhn',
                    ],
                    'radioButton1' => [
                        'value' => 'ujm',
                    ],
                    'spin1' => [
                        'value' => 123,
                    ],
                    'currency1' => [
                        'value' => 153,
                    ],
                    'month1' => [
                        'value' => 9,
                    ],
                    'month2' => [
                        'value' => 11,
                    ],
                    'year1' => [
                        'value' => 1990,
                    ],
                    'date1' => [
                        // intentionally empty
                    ],
                    'date2' => [
                        'value' => new \DateTime('2021-11-26 19:32:24'),
                    ],
                    'date3' => [
                        'value' => '2017-08-31 02:48:35',
                    ],
                    'date4' => [
                        'value' => '2017-08-31 02:48:35',
                    ],
                    'text1' => [
                        'value' => 'bar',
                    ],
                    'text2' => [
                        'value' => 'baz',
                    ],
                    'text3' => [
                        'value' => 'faz',
                    ],
                    'combobox1' => [
                        'value' => 'okm',
                    ],
                    'combobox2' => [
                        'value' => 'ijn',
                    ],
                    'combobox3' => [
                        'value' => 'uhb',
                    ],
                    'comboboxEx1' => [
                        'value' => 'zgv',
                    ],
                    'comboboxEx2' => [
                        'value' => 'tfc',
                    ],
                ],
            ],
        ]);
    }
}
