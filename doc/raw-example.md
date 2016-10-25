# Example

This example show how to use it in a raw that will receive a POST request.

```php
<?php

require 'vendor/autoload.php';

use Sensorario\Resources\Resource;
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;

$request = file_get_contents('php://input');

try {
    Resource::box(
        json_decode($request, true),
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


echo $request;
```
