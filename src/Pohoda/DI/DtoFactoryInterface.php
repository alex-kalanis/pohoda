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
     * @param class-string<AbstractDto>|AbstractDto $name
     * @throws DomainException
     * @return AbstractDto
     */
    public function getDto(string|AbstractDto $name): AbstractDto;
}
