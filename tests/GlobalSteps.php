<?php

// php8.2
if (!class_exists('AllowDynamicProperties')) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class AllowDynamicProperties {}
}

if (!class_exists('SensitiveParameter')) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter {}
}
