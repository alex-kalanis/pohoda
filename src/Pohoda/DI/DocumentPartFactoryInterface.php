<?php

namespace Riesenia\Pohoda\DI;

use DomainException;
use Riesenia\Pohoda\Document;

/**
 * Get DocumentPart class
 */
interface DocumentPartFactoryInterface
{
    /**
     * @param string $parentClass
     * @param string $name
     * @throws DomainException
     * @return Document\AbstractPart
     */
    public function getPart(string $parentClass, string $name): Document\AbstractPart;
}
