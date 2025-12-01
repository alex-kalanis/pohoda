<?php

namespace tests\AgendaTests\Document;

use kalanis\PohodaException;
use tests\CommonTestClass;

class AbstractSummaryTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentSummary($this->getBasicDi());
        $this->expectException(PohodaException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentSummary($this->getBasicDi());
        $lib->setNamespace('bar');
        $this->expectException(PohodaException::class);
        $lib->getXML();
    }
}
