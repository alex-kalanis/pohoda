<?php

namespace BasicTests;

use CommonTestClass;
use Riesenia\Pohoda;


class ContractTest extends CommonTestClass
{
    public function testInit(): void
    {
        $lib = $this->getLib();
        $this->assertInstanceOf(Pohoda\Contract::class, $lib);
        $this->assertInstanceOf(Pohoda\AbstractAgenda::class, $lib);
        $this->assertEquals('lCon:contract', $lib->getImportRoot());
    }

    public function testCreateCorrectXml(): void
    {
        $this->assertEquals('<con:contract version="2.0"><con:contractDesc>' . $this->defaultHeader() . '</con:contractDesc></con:contract>', $this->getLib()->getXML()->asXML());
    }

    public function testSetParams(): void
    {
        $lib = $this->getLib();
        $lib->addParameter('VPrNum', 'number', 10.43);

        $this->assertEquals('<con:contract version="2.0"><con:contractDesc>' . $this->defaultHeader() . '<con:parameters><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter></con:parameters></con:contractDesc></con:contract>', $lib->getXML()->asXML());
    }

    public function testDiffPartner(): void
    {
        $lib = new Pohoda\Contract([
            'text' => 'zakazka1337',
            'responsiblePerson' => ['ids' => 'Z0005'],
            'partnerIdentity' => [
                'address' => [
                    'company' => 'Access',
                    'name' => 'Someone',
                    'city' => 'Capital',
                    'street' => 'King\'s',
                    'country' => 'Tonga',
                    'phone' => '+9999123456789',
                    'email' => 'fooz@example.com',
                ],
            ],
        ], '123');
        $lib->addParameter('VPrNum', 'number', 10.43);

        $this->assertEquals('<con:contract version="2.0"><con:contractDesc><con:text>zakazka1337</con:text><con:partnerIdentity><typ:address><typ:company>Access</typ:company><typ:name>Someone</typ:name><typ:city>Capital</typ:city><typ:street>King\'s</typ:street><typ:country><typ:ids>Tonga</typ:ids></typ:country><typ:phone>+9999123456789</typ:phone><typ:email>fooz@example.com</typ:email></typ:address></con:partnerIdentity><con:responsiblePerson><typ:ids>Z0005</typ:ids></con:responsiblePerson><con:parameters><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter></con:parameters></con:contractDesc></con:contract>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<con:text>zakazka15</con:text><con:responsiblePerson><typ:ids>Z0005</typ:ids></con:responsiblePerson>';
    }

    protected function getLib(): Pohoda\Contract
    {
        return new Pohoda\Contract([
            'text' => 'zakazka15',
            'responsiblePerson' => ['ids' => 'Z0005']
        ], '123');
    }
}
