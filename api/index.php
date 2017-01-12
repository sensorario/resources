<?php

require '../vendor/autoload.php';

use Sensorario\Resources\Resource;
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;

try {
    Resource::box(
        json_decode(json_encode($_GET), true),
        new Configurator(
            'resource',
            new Container(array(
                'resources' => array(
                    'resource' => array(
                        'constraints' => array(
                            'mandatory' => array(
                                'foo',
                                'bar'
                            )
                        )
                    )
                )
            ))
        )
    );
} catch (\Exception $exception) {
    die(json_encode([
        'message' => $exception->getMessage()
    ]));
}

echo json_encode($_GET);
