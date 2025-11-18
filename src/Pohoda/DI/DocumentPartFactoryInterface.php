<?php

namespace kalanis\Pohoda\DI;

use DomainException;
use kalanis\Pohoda\Document;

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
