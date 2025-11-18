<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use kalanis\Pohoda;

class BankTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Bank::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lst:bank', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader></bnk:bank>', $this->getLib()->getXML()->asXML());
    }

    public function testSetSummary(): void
    {
        $home = new Pohoda\Type\Dtos\CurrencyHomeDto();
        $home->priceNone = 500;

        $summary = new Pohoda\Bank\SummaryDto();
        $summary->homeCurrency = $home;

        $lib = $this->getLib();
        $lib->addSummary($summary);

        $this->assertEquals('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader><bnk:bankSummary><bnk:homeCurrency><typ:priceNone>500</typ:priceNone></bnk:homeCurrency></bnk:bankSummary></bnk:bank>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
    {
        $lib = $this->getLib();

        $home1 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home1->unitPrice = 153;

        $item1 = new Pohoda\Bank\ItemDto();
        $item1->text = 'test one';
        $item1->quantity = 369;
        $item1->unit = 2;
        $item1->note = 'testing one';
        $item1->homeCurrency = $home1;

        $lib->addItem($item1);

        $home2 = new Pohoda\Type\Dtos\CurrencyItemDto();
        $home2->price = 816;

        $item2 = new Pohoda\Bank\ItemDto();
        $item2->text = 'test two';
        $item2->quantity = 42;
        $item2->unit = 816;
        $item2->note = 'testing two';
        $item2->homeCurrency = $home2;

        $lib->addItem($item2);

        $this->assertEquals('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader><bnk:bankDetail><bnk:bankItem><bnk:text>test one</bnk:text><bnk:quantity>369</bnk:quantity><bnk:unit>2</bnk:unit><bnk:homeCurrency><typ:unitPrice>153</typ:unitPrice></bnk:homeCurrency><bnk:note>testing one</bnk:note></bnk:bankItem><bnk:bankItem><bnk:text>test two</bnk:text><bnk:quantity>42</bnk:quantity><bnk:unit>816</bnk:unit><bnk:homeCurrency><typ:price>816</typ:price></bnk:homeCurrency><bnk:note>testing two</bnk:note></bnk:bankItem></bnk:bankDetail></bnk:bank>', $lib->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('IsOn', 'boolean', 'true');
        $lib->addParameter('VPrNum', 'number', 10.43);
        $lib->addParameter('RefVPrCountry', 'list', 'SK', 'Country');
        $lib->addParameter('CustomList', 'list', ['id' => 5], ['id' => 6]);

        $this->assertEquals('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '<bnk:parameters><typ:parameter><typ:name>VPrIsOn</typ:name><typ:booleanValue>true</typ:booleanValue></typ:parameter><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter><typ:parameter><typ:name>RefVPrCountry</typ:name><typ:listValueRef><typ:ids>SK</typ:ids></typ:listValueRef><typ:list><typ:ids>Country</typ:ids></typ:list></typ:parameter><typ:parameter><typ:name>RefVPrCustomList</typ:name><typ:listValueRef><typ:id>5</typ:id></typ:listValueRef><typ:list><typ:id>6</typ:id></typ:list></typ:parameter></bnk:parameters></bnk:bankHeader></bnk:bank>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<bnk:bankType>receipt</bnk:bankType><bnk:account><typ:ids>KB</typ:ids></bnk:account><bnk:statementNumber><bnk:statementNumber>004</bnk:statementNumber><bnk:numberMovement>0002</bnk:numberMovement></bnk:statementNumber><bnk:symVar>456</bnk:symVar><bnk:dateStatement>2021-12-20</bnk:dateStatement><bnk:datePayment>2021-11-22</bnk:datePayment><bnk:text>STORMWARE s.r.o.</bnk:text><bnk:paymentAccount><typ:accountNo>4660550217</typ:accountNo><typ:bankCode>5500</typ:bankCode></bnk:paymentAccount><bnk:symConst>555</bnk:symConst><bnk:symSpec>666</bnk:symSpec>';
    }

    protected function getLib(): Pohoda\Bank
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

        $lib = new Pohoda\Bank($this->getBasicDi());
        return $lib->setData($dto);
    }

    // testing RefItem in AbstractAgenda
    public function testItem1(): void
    {
        $item = new Pohoda\Bank\ItemDto();
        $item->accounting = [
            'which' => [ // deeper, items
                '123',
                '456',
                '789',
            ],
        ];

        $lib = new Pohoda\Bank\Item($this->getBasicDi());
        $lib->setData($item);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEquals('<lst:testItem><lst:accounting><lst:which>123</lst:which><lst:which>456</lst:which><lst:which>789</lst:which></lst:accounting></lst:testItem>', $lib->getXML()->asXML());
    }

    public function testItem2(): void
    {
        $item = new Pohoda\Bank\ItemDto();
        $item->accounting = [
            'which' => [ // deeper, items
                'foo' => '123',
                'bar' => '456',
                'baz' => '789',
            ],
        ];

        $lib = new Pohoda\Bank\Item($this->getBasicDi());
        $lib->setData($item);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEquals('<lst:testItem><lst:accounting><lst:which><typ:foo>123</typ:foo><typ:bar>456</typ:bar><typ:baz>789</typ:baz></lst:which></lst:accounting></lst:testItem>', $lib->getXML()->asXML());
    }
}
