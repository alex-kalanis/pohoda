<?php

namespace ValueTransformerTests;


use CommonTestClass;
use Riesenia\Pohoda\ValueTransformer;


class SanitizeTest extends CommonTestClass
{
    public function testOk(): void
    {
        $lib = new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing());
        $this->assertEquals('windows-1250', $lib->getEncoding());
        $lib->willBeSanitized(false);
        $lib->listingWithEncoding();
        $this->assertEquals(0, \count($lib->getListing()->getTransformers()));

        $lib->willBeSanitized(true);
        $lib->listingWithEncoding();
        $this->assertEquals(2, \count($lib->getListing()->getTransformers()));

        $lib->getListing()->clear();
        $this->assertEquals(0, \count($lib->getListing()->getTransformers()));
    }
}
