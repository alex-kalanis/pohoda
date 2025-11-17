<?php

namespace tests\AttributesTests\Normalizer;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use tests\CommonTestClass;

abstract class AbstractNormalizerTestClass extends CommonTestClass
{
    protected function getResolver(bool $directional, bool $withAttributes): Common\OptionsResolver
    {
        $agenda = $this->getAgenda();
        $resolver = Common\SharedResolver::getResolver(
            $agenda,
            $directional,
            [],
        );
        $resolver->setDefined(Common\Dtos\Processing::getProperties(
            $agenda->getDefaultDto(),
            $withAttributes,
            $directional,
        ));
        Common\OptionsResolver\Normalizers\NormalizerFactory::loadNormalizersFromDto(
            $resolver,
            $agenda->getDefaultDto(),
            $directional,
        );
        return $resolver;
    }

    protected function getAgenda(): AbstractAgenda
    {
        return new XDummyAgenda($this->getBasicDi());
    }
}
