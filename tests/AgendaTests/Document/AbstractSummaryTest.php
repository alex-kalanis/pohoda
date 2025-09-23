<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\CompanyRegistrationNumber;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class AbstractSummaryTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentSummary(new NamespacesPaths(), new SanitizeEncoding(new Listing()), CompanyRegistrationNumber::init('foo'));
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentSummary(new NamespacesPaths(), new SanitizeEncoding(new Listing()), CompanyRegistrationNumber::init('foo'));
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }
}
