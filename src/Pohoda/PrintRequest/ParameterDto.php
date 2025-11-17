<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Common\OptionsResolver;

class ParameterDto extends AbstractDto
{
    #[Attributes\OnlyInternal, Attributes\JustAttribute]
    public ?string $type = null;
    #[Attributes\Options\CallbackOption(['\Riesenia\Pohoda\PrintRequest\ParameterDto', 'normalizeValue'])]
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
