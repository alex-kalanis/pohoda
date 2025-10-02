<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use PhpSpec\ObjectBehavior;
use spec\Riesenia\DiTrait;

class PrintRequestSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $this->beConstructedWith($this->getBasicDi());
        $this->setData([
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
            ],
        ]);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\PrintRequest');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<prn:print version="1.0"><prn:record agenda="vydane_faktury"><ftr:filter><ftr:id>1234</ftr:id></ftr:filter></prn:record><prn:printerSettings><prn:report><prn:id>5678</prn:id></prn:report><prn:pdf><prn:fileName>C:\Test\1234.pdf</prn:fileName></prn:pdf></prn:printerSettings></prn:print>');
    }
}
