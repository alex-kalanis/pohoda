<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;

class AbstractSummaryTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentSummary($this->getBasicDi());
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentSummary($this->getBasicDi());
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }
}
