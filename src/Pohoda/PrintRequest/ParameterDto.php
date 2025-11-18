<?php

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Common\OptionsResolver;

class ParameterDto extends AbstractDto
{
    #[Attributes\OnlyInternal, Attributes\JustAttribute]
    public ?string $type = null;
    #[Attributes\Options\CallbackOption(['\kalanis\Pohoda\PrintRequest\ParameterDto', 'normalizeValue'])]
    public mixed $value = null;

    public static function init(mixed $value = null, ?string $type = null): self
    {
        $dto = new self();
        $dto->value = $value;
        $dto->type = $type;
        return $dto;
    }

    public static function normalizeValue(OptionsResolver $options, mixed $value, ?ParameterDto $dto): mixed
    {
        $normalizerClass = OptionsResolver\Normalizers\NormalizerFactory::createNormalizer(\strval($dto?->type));
        return $normalizerClass->normalize($options, $value);
    }
}
