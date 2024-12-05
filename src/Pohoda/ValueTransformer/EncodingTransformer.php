<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\ValueTransformer;

/**
 * A transformer that converts the encoding of a string.
 *
 * Since most transformers will expect UTF-8 formatted strings, this transformer should either be the last
 * to run or be immediately followed by another one that will convert the string back to UTF-8.
 */
class EncodingTransformer implements ValueTransformer
{
    public function __construct(
        protected readonly string $fromEncoding,
        protected readonly string $toEncoding,
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function transform(string $value): string
    {
        $result = \iconv($this->fromEncoding, $this->toEncoding, $value);

        if (false === $result) {
            return $value;
        }

        return $result;
    }
}
