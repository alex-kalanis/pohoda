<?php

namespace BasicTests;


use CommonTestClass;
use Riesenia\Pohoda;


class ListRequestTest extends CommonTestClass
{
    public function testRestrict(): void
    {
        $lib = new Pohoda\ListRequest(['type' => 'Invoice'], '123');
        $lib->addRestrictionData(['liquidations' => true]);
        $this->assertEquals('<lst:listInvoiceRequest version="2.0" invoiceVersion="2.0" invoiceType="issuedInvoice"><lst:requestInvoice/><lst:restrictionData><lst:liquidations>true</lst:liquidations></lst:restrictionData></lst:listInvoiceRequest>', $lib->getXML()->asXML());
    }
}
