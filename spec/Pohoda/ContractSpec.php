<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class ContractSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $header = new Pohoda\Contract\DescDto();
        $header->text = 'zakazka15';
        $header->responsiblePerson = ['ids' => 'Z0005'];

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($header);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\Contract');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
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
