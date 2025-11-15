<?php

namespace tests\AgendaTests;

use tests\CommonTestClass;
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
        $partnerAddr = new Pohoda\Type\Dtos\AddressTypeDto();
        $partnerAddr->company = 'Access';
        $partnerAddr->name = 'Someone';
        $partnerAddr->city = 'Capital';
        $partnerAddr->street = 'King\'s';
        $partnerAddr->country = 'Tonga';
        $partnerAddr->phone = '+9999123456789';
        $partnerAddr->email = 'fooz@example.com';

        $partner = new Pohoda\Type\Dtos\AddressDto();
        $partner->address = $partnerAddr;

        $header = new Pohoda\Contract\DescDto();
        $header->text = 'zakazka1337';
        $header->responsiblePerson = ['ids' => 'Z0005'];
        $header->partnerIdentity = $partner;

        $lib = new Pohoda\Contract($this->getBasicDi());
        $lib->setData($header);
        $lib->addParameter('VPrNum', 'number', 10.43);

        $this->assertEquals('<con:contract version="2.0"><con:contractDesc><con:text>zakazka1337</con:text><con:partnerIdentity><typ:address><typ:company>Access</typ:company><typ:name>Someone</typ:name><typ:city>Capital</typ:city><typ:street>King\'s</typ:street><typ:country><typ:ids>Tonga</typ:ids></typ:country><typ:phone>+9999123456789</typ:phone><typ:email>fooz@example.com</typ:email></typ:address></con:partnerIdentity><con:responsiblePerson><typ:ids>Z0005</typ:ids></con:responsiblePerson><con:parameters><typ:parameter><typ:name>VPrNum</typ:name><typ:numberValue>10.43</typ:numberValue></typ:parameter></con:parameters></con:contractDesc></con:contract>', $lib->getXML()->asXML());
    }

    protected function defaultHeader(): string
    {
        return '<con:text>zakazka15</con:text><con:responsiblePerson><typ:ids>Z0005</typ:ids></con:responsiblePerson>';
    }

    protected function getLib(): Pohoda\Contract
    {
        $header = new Pohoda\Contract\DescDto();
        $header->text = 'zakazka15';
        $header->responsiblePerson = ['ids' => 'Z0005'];

        $lib = new Pohoda\Contract($this->getBasicDi());
        return $lib->setData($header);
    }
}
