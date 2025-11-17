<?php

namespace tests\AttributesTests;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

/**
 * This DTO is only for check request/response types
 */
class XCallbackDto extends AbstractDto
{
    #[Attributes\Options\CallbackOption(['\tests\AttributesTests\XCallbackDto', 'call1'])]
    public array|string|null $callback1 = null;
    #[Attributes\Options\CallbackOption(['\tests\AttributesTests\XCallbackDto', 'call2'])]
    public array|string|null $callback2 = null;
    #[Attributes\Options\CallbackOption(['\tests\AttributesTests\XCallbackDto', 'call3'])]
    public array|string|null $callback3 = null;
    #[Attributes\Options\CallbackOption]
    public array|string|null $callback4 = null; // example of empty call
    #[Attributes\Options\DefaultOption(['\tests\AttributesTests\XCallbackDto', 'call5'])]
    public array|string|null $callback5 = null;
    #[Attributes\Options\DefaultOption(['\tests\AttributesTests\XCallbackDto', 'call6'])]
    public array|string|null $callback6 = null;
    #[Attributes\Options\DefaultOption(['\tests\AttributesTests\XCallbackDto', 'call7'])]
    public array|string|null $callback7 = null;

    public static function call1(mixed $options, mixed $value): string
    {
        return '123456';
    }

    public static function call2(mixed $options, mixed $value): string
    {
        return '';
    }

    public static function call3(mixed $options, mixed $value): string
    {
        return \strval(\intval(!empty($value)));
    }

    public static function call5(mixed $options): string
    {
        return '123456';
    }

    public static function call6(mixed $options): string
    {
        return '';
    }

    public static function call7(mixed $options): string
    {
        return \strval(\intval(!empty($options)));
    }
}
