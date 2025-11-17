<?php

namespace tests\AttributesTests\Normalizer;

use Riesenia\Pohoda\AbstractAgenda;

class ListRequestsTest extends AbstractNormalizerTestClass
{
    public function testBasic(): void
    {
        $resolved = $this->getResolver(false, false)
            ->resolve([
                'type1' => 'foo-bar-baz',
                'type2' => 'Addressbook',
                'type3' => 'IssueSlip',
                'type4' => 'CashSlip',
            ]);
        $this->assertEquals('foo-bar-baz', $resolved['type1']);
        $this->assertEquals('AddressBook', $resolved['type2']);
        $this->assertEquals('Vydejka', $resolved['type3']);
        $this->assertEquals('Prodejka', $resolved['type4']);
    }

    protected function getAgenda(): AbstractAgenda
    {
        return new XListAgenda($this->getBasicDi());
    }
}
