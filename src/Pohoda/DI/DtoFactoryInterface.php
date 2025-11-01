<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

/**
 * Get Dto class
 */
interface DtoFactoryInterface
{
    /**
     * @param string|object $name
     * @throws DomainException
     * @return AbstractDto
     */
    public function getDto(string|object $name): AbstractDto;
}
