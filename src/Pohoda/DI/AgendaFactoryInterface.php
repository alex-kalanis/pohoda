<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Riesenia\Pohoda\AbstractAgenda;

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
