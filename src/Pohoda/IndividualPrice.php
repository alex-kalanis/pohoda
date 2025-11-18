<?php

declare(strict_types=1);

namespace kalanis\Pohoda;

use kalanis\Pohoda\Common\OptionsResolver;

class IndividualPrice extends AbstractAgenda
{
    public function getImportRoot(): string
    {
        return 'lst:individualPrice';
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        throw new \DomainException('Individual prices import is currently not supported.');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Common\Dtos\EmptyDto();
    }
}
