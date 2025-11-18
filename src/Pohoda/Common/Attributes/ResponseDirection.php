<?php

namespace kalanis\Pohoda\Common\Attributes;

use Attribute;

/**
 * The variable is only used when direction is set to response
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ResponseDirection {}
