<?php

$_ENV = getenv();
date_default_timezone_set("UTC");
require __DIR__ . "/../../../vendor/autoload.php";

use dhope0000\LXDClient\Constants\Constants;

$builder = new \DI\ContainerBuilder();
$container = $builder->build();

$removeDead = $container->make("dhope0000\LXDClient\Tools\Backups\Schedule\RemoveDeadBackupSchedules");

$removeDead->remove();
