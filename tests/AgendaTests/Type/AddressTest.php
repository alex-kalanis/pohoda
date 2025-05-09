<?php

namespace AgendaTests\Type;


use CommonTestClass;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Type\Address;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class AddressTest extends CommonTestClass
{
    public function testUpdateParams(): void
    {
        $lib = new Address(new NamespacesPaths(), new SanitizeEncoding(new Listing()), [
            'shipToAddress' => [
                'name' => 'example',
            ],
            ], 'foo');
        $lib->setNamespace('lst');
        $lib->setNodeName('bar');
        $this->assertEquals('', $lib->getXML());
    }
}
