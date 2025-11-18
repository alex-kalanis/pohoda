<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests/data')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS2x0' => true,
        'concat_space' => false,
        'phpdoc_order' => true,
        'cast_spaces' => true,
        'declare_strict_types' => false,
    ])
    ->setFinder($finder);

return $config;
