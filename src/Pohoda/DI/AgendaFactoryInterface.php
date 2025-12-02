<?php

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\PohodaException;

/**
 * Get Agenda class
 */
interface AgendaFactoryInterface
{
    /**
     * @param string $name
     * @throws PohodaException
     * @return AbstractAgenda
     */
    public function getAgenda(string $name): AbstractAgenda;
}
