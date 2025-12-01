<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Common\OptionsResolver;
use kalanis\PohodaException;

/**
 * Basic DTO for parameters
 */
class ParameterDto extends AbstractDto
{
    #[Attributes\Options\CallbackOption(['\kalanis\Pohoda\Type\Dtos\ParameterDto', 'normalizeName']), Attributes\Options\RequiredOption]
    public ?string $name = null;
    #[Attributes\Options\ListOption(['text', 'memo', 'currency', 'boolean', 'number', 'datetime', 'integer', 'list']), Attributes\Options\RequiredOption]
    public ?string $type = null;
    #[Attributes\Options\CallbackOption(['\kalanis\Pohoda\Type\Dtos\ParameterDto', 'normalizeList'])]
    public mixed $value = null;
    public mixed $list = null;

    public static function normalizeName(OptionsResolver $options, mixed $value): string
    {
        $prefix = 'VPr';
        $value = \strval($value);

        if ('list' == $options['type']) {
            $prefix = 'RefVPr';
        }

        if (\str_starts_with($value, $prefix)) {
            return $value;
        }

        return $prefix . $value;
    }

    public static function normalizeList(OptionsResolver $options, mixed $value): mixed
    {
        $normalizer = $options['type'];

        // date for datetime
        if ('datetime' == $normalizer) {
            $normalizer = 'date';
        }

        try {
            $normalizerClass = OptionsResolver\Normalizers\NormalizerFactory::createNormalizer(\strval($normalizer));
            return \call_user_func($normalizerClass->normalize(...), [], $value);
        } catch (PohodaException) {
            return \is_array($value) ? $value : \strval($value);
        }
    }
}
