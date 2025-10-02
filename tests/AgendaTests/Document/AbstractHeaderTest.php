<?php

namespace tests\AgendaTests\Document;

use tests\CommonTestClass;
use LogicException;

class AbstractHeaderTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new XDocumentHeader($this->getBasicDi());
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testNoPrefix(): void
    {
        $lib = new XDocumentHeader($this->getBasicDi());
        $lib->setNamespace('bar');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }
}
