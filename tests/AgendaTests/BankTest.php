<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

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
        $lib = $this->getLib();
        $lib->addSummary([
            'homeCurrency' => [
                'priceNone' => 500
            ]
        ]);

        $this->assertEquals('<bnk:bank version="2.0"><bnk:bankHeader>' . $this->defaultHeader() . '</bnk:bankHeader><bnk:bankSummary><bnk:homeCurrency><typ:priceNone>500</typ:priceNone></bnk:homeCurrency></bnk:bankSummary></bnk:bank>', $lib->getXML()->asXML());
    }

    public function testSetItem(): void
    {
        $lib = $this->getLib();
        $lib->addItem([
            'text' => 'test one',
            'quantity' => 369,
            'unit' => 2,
            'homeCurrency' => [
                'unitPrice' => 153,
            ],
            'note' => 'testing one',
        ]);
        $lib->addItem([
            'text' => 'test two',
            'quantity' => 42,
            'unit' => 816,
            'homeCurrency' => [
                'price' => 816,
            ],
            'note' => 'testing two',
        ]);

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
        $lib = new Pohoda\Bank(
            new Pohoda\Common\NamespacesPaths(),
            new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()),
            '123');
        return $lib->setData([
            'bankType' => 'receipt',
            'account' => 'KB',
            'statementNumber' => [
                'statementNumber' => '004',
                'numberMovement' => '0002'
            ],
            'symVar' => '456',
            'symConst' => '555',
            'symSpec' => '666',
            'dateStatement' => '2021-12-20',
            'datePayment' => '2021-11-22',
            'text' => 'STORMWARE s.r.o.',
            'paymentAccount' => [
                'accountNo' => '4660550217',
                'bankCode' => '5500'
            ]
        ]);
    }

    // testing RefItem in AbstractAgenda
    public function testItem1(): void
    {
        $lib = new Pohoda\Bank\Item(
            new Pohoda\Common\NamespacesPaths(),
            new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()),
            '123',
        );
        $lib->setData([
            'accounting' => [
                'which' => [ // deeper, list
                    '123',
                    '456',
                    '789',
                ]
            ],
        ]);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEquals('<lst:testItem><lst:accounting><lst:which>123</lst:which><lst:which>456</lst:which><lst:which>789</lst:which></lst:accounting></lst:testItem>', $lib->getXML()->asXML());
    }

    public function testItem2(): void
    {
        $lib = new Pohoda\Bank\Item(
            new Pohoda\Common\NamespacesPaths(),
            new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()),
            '123',
        );
        $lib->setData([
            'accounting' => [
                'which' => [ // deeper, items
                    'foo' => '123',
                    'bar' => '456',
                    'baz' => '789',
                ]
            ],
        ]);
        $lib->setNamespace('lst');
        $lib->setNodePrefix('test');
        $this->assertEquals('<lst:testItem><lst:accounting><lst:which><typ:foo>123</typ:foo><typ:bar>456</typ:bar><typ:baz>789</typ:baz></lst:which></lst:accounting></lst:testItem>', $lib->getXML()->asXML());
    }
}
