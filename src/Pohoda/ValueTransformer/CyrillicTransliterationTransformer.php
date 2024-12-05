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
 * A transformer that rewrites Cyrillic script to its Latin alphabet equivalent.
 *
 * Note: This transformation is a phonetic representation and does not provide a translation of the text.
 */
class CyrillicTransliterationTransformer implements ValueTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(string $value): string
    {
        $normalized = \Normalizer::normalize($value, \Normalizer::FORM_C);

        if (false === $normalized) {
            return $value;
        }

        $transformer = \Transliterator::create('Any-Latin; Latin-ASCII');

        if (is_null($transformer)) {
            return $value;
        }

        $chars = \preg_split('//u', $normalized, -1, PREG_SPLIT_NO_EMPTY);

        if (false === $chars) {
            return $value;
        }

        $result = '';

        foreach ($chars as $char) {
            $codePoint = \mb_ord($char, 'UTF-8');

            if ((0x00400 <= $codePoint && 0x004FF >= $codePoint)    // Cyrillic Basic
                || (0x00500 <= $codePoint && 0x0052F >= $codePoint) // Cyrillic Supplement
                || (0x02DE0 <= $codePoint && 0x02DFF >= $codePoint) // Cyrillic Extended-A
                || (0x0A640 <= $codePoint && 0x0A69F >= $codePoint) // Cyrillic Extended-B
                || (0x01C80 <= $codePoint && 0x01C8F >= $codePoint) // Cyrillic Extended-C
                || (0x1E030 <= $codePoint && 0x1E08F >= $codePoint) // Cyrillic Extended-D
            ) {
                $result .= $transformer->transliterate($char);
            } else {
                $result .= $char;
            }
        }

        return $result;
    }
}
