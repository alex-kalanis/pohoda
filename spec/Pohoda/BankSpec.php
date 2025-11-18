<?php

declare(strict_types=1);

namespace spec\kalanis\Pohoda;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'DiTrait.php';

use kalanis\Pohoda;
use PhpSpec\ObjectBehavior;
use spec\kalanis\DiTrait;

class BankSpec extends ObjectBehavior
{
    use DiTrait;

    public function let(): void
    {
        $statement = new Pohoda\Bank\StatementNumberDto();
        $statement->statementNumber = '004';
        $statement->numberMovement = '0002';

        $header = new Pohoda\Bank\HeaderDto();
        $header->bankType = 'receipt';
        $header->account = 'KB';
        $header->symVar = '456';
        $header->symConst = '555';
        $header->symSpec = '666';
        $header->dateStatement = '2021-12-20';
        $header->datePayment = '2021-11-22';
        $header->text = 'STORMWARE s.r.o.';
        $header->statementNumber = $statement;
        $header->paymentAccount = [
            'accountNo' => '4660550217',
            'bankCode' => '5500',
        ];

        $dto = new Pohoda\Bank\BankDto();
        $dto->header = $header;

        $this->beConstructedWith($this->getBasicDi());
        $this->setData($dto);
    }

    public function it_is_initializable_and_extends_agenda(): void
    {
        $this->shouldHaveType('kalanis\Pohoda\Bank');
        $this->shouldHaveType('kalanis\Pohoda\AbstractAgenda');
    }

    public function it_creates_correct_xml(): void
    {
        $this->getXML()->asXML()->shouldReturn('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader></bnk:bank>');
    }

    public function it_can_set_summary(): void
    {
        $home = new Pohoda\Type\Dtos\CurrencyHomeDto();
        $home->priceNone = 500;

        $summary = new Pohoda\Bank\SummaryDto();
        $summary->homeCurrency = $home;

        $this->addSummary($summary);

        $this->getXML()->asXML()->shouldReturn('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader><bnk:bankSummary><bnk:homeCurrency><typ:priceNone>500</typ:priceNone></bnk:homeCurrency></bnk:bankSummary></bnk:bank>');
    }

    public function it_can_set_parameters(): void
    {
        $this->addParameter('IsOn', 'boolean', 'true');
        $this->addParameter('VPrNum', 'number', 10.43);
        $this->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $this->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->getXML()->asXML()->shouldReturn('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '<bnk:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></bnk:parameters></bnk:bankHeader></bnk:bank>');
    }

    protected function defaultHeader(): string
    {
        return '<bnk:bankType>receipt</bnk:bankType><bnk:account><typ:ids>KB</typ:ids></bnk:account><bnk:statementNumber><bnk:statementNumber>004</bnk:statementNumber><bnk:numberMovement>0002</bnk:numberMovement></bnk:statementNumber><bnk:symVar>456</bnk:symVar><bnk:dateStatement>2021-12-20</bnk:dateStatement><bnk:datePayment>2021-11-22</bnk:datePayment><bnk:text>STORMWARE s.r.o.</bnk:text><bnk:paymentAccount><typ:accountNo>4660550217</typ:accountNo><typ:bankCode>5500</typ:bankCode></bnk:paymentAccount><bnk:symConst>555</bnk:symConst><bnk:symSpec>666</bnk:symSpec>';
    }
}
