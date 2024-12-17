<?php

namespace AgendaTests\Type;


use CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Type\ActionType;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class ActionTypeTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new ActionType(new NamespacesPaths(), new SanitizeEncoding(new Listing()), ['type' => 'add'], 'foo');
        $this->expectException(LogicException::class);
        $lib->getXML();
    }

    public function testUpdateParams(): void
    {
        $lib = new ActionType(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [
            'type' => 'add/update',
            ], 'foo', false);
        $lib->setNamespace('lst');
        $this->assertEquals('', $lib->getXML());
    }
}
