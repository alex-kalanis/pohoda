<?php

namespace Riesenia\Pohoda\Common\Attributes;

use Attribute;

/**
 * Only internal content - do not export when process
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class OnlyInternal {}
