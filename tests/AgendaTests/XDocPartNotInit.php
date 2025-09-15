<?php

namespace tests\AgendaTests;

use Riesenia\Pohoda;
use Riesenia\Pohoda\ValueTransformer;

class XDocPartNotInit extends Pohoda\Document\AbstractPart
{
    protected function __construct()
    {
        // this one will kill the init - cannot initialize protected
        parent::__construct(new Pohoda\Common\NamespacesPaths(), new ValueTransformer\SanitizeEncoding(new ValueTransformer\Listing()), 'num');
    }

    public function configureOptions(Pohoda\Common\OptionsResolver $resolver): void {}
}
