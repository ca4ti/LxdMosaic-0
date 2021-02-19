<?php

$_ENV = getenv();

require __DIR__ . "/../../../vendor/autoload.php";

use dhope0000\LXDClient\Constants\Constants;

$builder = new \DI\ContainerBuilder();
$container = $builder->build();

$removeAnalytics = $container->make("dhope0000\LXDClient\Tools\Instances\Metrics\RemoveMetrics");

$removeAnalytics->remove();
