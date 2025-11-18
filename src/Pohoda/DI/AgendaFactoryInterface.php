<?php

namespace kalanis\Pohoda\DI;

use DomainException;
use kalanis\Pohoda\AbstractAgenda;

/**
 * Get Agenda class
 */
interface AgendaFactoryInterface
{
    /**
     * @param string $name
     * @throws DomainException
     * @return AbstractAgenda
     */
    public function getAgenda(string $name): AbstractAgenda;
}
