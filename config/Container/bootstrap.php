<?php

use DI\ContainerBuilder;

require (require dirname(__FILE__, 3) . 'includes/loader.php') (__FILE__);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/containerConfig.php');

try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
    (new Symfony\Component\Console\Output\ConsoleOutput())->writeln($e->getMessage());
    exit(1);
}

return $container;
