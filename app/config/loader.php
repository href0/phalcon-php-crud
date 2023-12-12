<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(
    [
        'Helper' =>  $config->namespace->Helper,
        // $config->namespace
    ]
);

$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
    ]
);

$loader->register();
