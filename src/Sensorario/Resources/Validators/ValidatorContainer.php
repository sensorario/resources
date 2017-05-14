<?php

namespace Sensorario\Resources\Validators;

use Sensorario\Container\ArgumentBuilder;

class ValidatorContainer
{
    public static function load() : \Sensorario\Container\Container
    {
        $container = new \Sensorario\Container\Container();

        $services = require __DIR__ . '/../../../../config/services.php';

        $container->loadServices($services);

        return $container;
    }
}
