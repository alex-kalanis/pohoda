<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for Rate VAT - with history values
 */
enum RateVatHistoryEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = 'none';
    case Third = 'third';
    case Low = 'low';
    case High = 'high';
    case HistoryThird = 'historyThird';
    case HistoryLow = 'historyLow';
    case HistoryHigh = 'historyHigh';

}
