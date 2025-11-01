<?php

/**
 * Dependency analyzer configuration
 * @link https://github.com/shipmonk-rnd/composer-dependency-analyser
 */

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

$config = new Configuration();

return $config
    // ignore errors on specific packages and paths
    // classes are defined in files for tests
    ->ignoreUnknownClasses([
        'Riesenia\Pohoda\XAgenda',
        'Riesenia\Pohoda\XClass',
        'Riesenia\Pohoda\XDocument',
        'Riesenia\Pohoda\XParameter',
    ])
;
