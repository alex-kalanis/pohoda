<?php

namespace kalanis\Pohoda\DI;

use kalanis\Pohoda\Document;
use kalanis\PohodaException;

/**
 * Get DocumentPart class
 */
interface DocumentPartFactoryInterface
{
    /**
     * @param string $parentClass
     * @param string $name
     * @throws PohodaException
     * @return Document\AbstractPart
     */
    public function getPart(string $parentClass, string $name): Document\AbstractPart;
}
