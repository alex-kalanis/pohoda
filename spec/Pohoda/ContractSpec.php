<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace spec\Riesenia\Pohoda;

use PhpSpec\ObjectBehavior;
use Riesenia\Pohoda\Common\NamespacesPaths;


class ContractSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(new NamespacesPaths(), [
            'text' => 'zakazka15',
            'responsiblePerson' => ['ids' => 'Z0005']
        ], '123');
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('Riesenia\Pohoda\Contract');
        $this->shouldHaveType('Riesenia\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<con:contract version="2.0"><con:contractDesc>' . $this->defaultHeader() . '</con:contractDesc></con:contract>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('VPrNum', 'number', 10.43);

        $this->getXML()->asXML()->shouldReturn('<con:contract version="2.0"><con:contractDesc>' . $this->defaultHeader() . '<con:parameters><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter></con:parameters></con:contractDesc></con:contract>');
    }

    protected function defaultHeader(): string
    {
        return '<con:text>zakazka15</con:text><con:responsiblePerson><typ:ids>Z0005</typ:ids></con:responsiblePerson>';
    }
}
