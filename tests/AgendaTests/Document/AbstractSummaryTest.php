<?php

namespace AgendaTests\Document;


use CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Document\AbstractSummary;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class AbstractSummaryTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentSummary(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [], 'foo');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentSummary(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [], 'foo');
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }
}


class XDocumentSummary extends AbstractSummary
{
}
