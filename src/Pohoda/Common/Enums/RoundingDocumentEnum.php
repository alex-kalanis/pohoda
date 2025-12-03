<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for Rounding Document - how it will be rounded
 */
enum RoundingDocumentEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = 'none';
    case Math2one = 'math2one';
    case Math2half = 'math2half';
    case Math2tenth = 'math2tenth';
    case Math5cent = 'math5cent';
    case Up2one = 'up2one';
    case Up2half = 'up2half';
    case Up2tenth = 'up2tenth';
    case Down2one = 'down2one';
    case Down2half = 'down2half';
    case Down2tenth = 'down2tenth';

}
