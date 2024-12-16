<?php

namespace AgendaTests;


use CommonTestClass;
use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;


class VoucherTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Voucher::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('vch:voucher', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<vch:voucher version="2.0"/>', $this->getLib()->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<bnk:bankType>receipt</bnk:bankType><bnk:account><typ:ids>KB</typ:ids></bnk:account><bnk:statementNumber><bnk:statementNumber>004</bnk:statementNumber><bnk:numberMovement>0002</bnk:numberMovement></bnk:statementNumber><bnk:symVar>456</bnk:symVar><bnk:dateStatement>2021-12-20</bnk:dateStatement><bnk:datePayment>2021-11-22</bnk:datePayment><bnk:text>STORMWARE s.r.o.</bnk:text><bnk:paymentAccount><typ:accountNo>4660550217</typ:accountNo><typ:bankCode>5500</typ:bankCode></bnk:paymentAccount><bnk:symConst>555</bnk:symConst><bnk:symSpec>666</bnk:symSpec>';
    }

    protected function getLib(): Pohoda\Voucher
    {
        return new Pohoda\Voucher(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), [
        ], '123');
    }
}
