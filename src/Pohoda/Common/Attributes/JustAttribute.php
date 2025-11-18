<?php

namespace kalanis\Pohoda\Common\Attributes;

use Attribute;

/**
 * The variable is used as attribute, do not use it for rendering
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class JustAttribute {}
