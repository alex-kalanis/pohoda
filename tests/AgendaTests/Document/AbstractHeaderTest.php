<?php

namespace AgendaTests\Document;


use CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Document\AbstractHeader;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class AbstractHeaderTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentHeader(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [], 'foo');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentHeader(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [], 'foo');
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }
}


class XDocumentHeader extends AbstractHeader
{
}
