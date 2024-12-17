<?php

namespace ValueTransformerTests;


use CommonTestClass;
use Riesenia\Pohoda\ValueTransformer;


class ListingTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new ValueTransformer\Listing();
        $this->assertEquals(0, \count($lib->getTransformers()));
        $lib->addTransformer(new ValueTransformer\IdentityTransformer());
        $this->assertEquals(1, \count($lib->getTransformers()));
        $lib->clear();
        $this->assertEquals(0, \count($lib->getTransformers()));
    }
}
