<?php

namespace tests\AgendaTests\Type;

use tests\CommonTestClass;
use LogicException;
use Riesenia\Pohoda\Common\CompanyRegistrationNumber;
use Riesenia\Pohoda\Common\NamespacesPaths;
use Riesenia\Pohoda\Type\ActionType;
use Riesenia\Pohoda\ValueTransformer\Listing;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class ActionTypeTest extends CommonTestClass
{
    public function testNoNamespace(): void
    {
        $lib = new ActionType(new NamespacesPaths(), new SanitizeEncoding(new Listing()), CompanyRegistrationNumber::init('foo'));
        $this->expectException(LogicException::class);
        $lib->setData(['type' => 'add'])->getXML();
    }

    public function testUpdateParams(): void
    {
        $lib = new ActionType(new NamespacesPaths(), new SanitizeEncoding(new Listing()), CompanyRegistrationNumber::init('foo'));
        $lib->setResolveOptions(false);
        $lib->setNamespace('lst');
        $this->assertEquals('', $lib->setData([
            'type' => 'add/update',
        ])->getXML());
    }
}
