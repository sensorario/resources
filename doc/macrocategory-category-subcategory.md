# Macrocategory Category Subcategory example

In this example we consider three allowed values:

 - macro category
 - category
 - subcatetory

```php
<?php

require './vendor/autoload.php';

use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;

$configurator = new Configurator(
    'company-name',
    new Container([
        'resources' => [
            'company-name' => [
                'constraints' => [
                    'allowed' => [
                        'macrocategory',
                        'category',
                        'subcategory',
                    ],
                    'mandatory' => [
                        'macrocategory' => [
                            'when' => [
                                'property' => 'category',
                                'condition' => 'is_present',
                            ]
                        ],
                        'category' => [
                            'when' => [
                                'property' => 'subcategory',
                                'condition' => 'is_present',
                            ]
                        ],
                    ],
                ]
            ],
        ],
    ])
);
```

The third one requires second. The second requires first. A request initialized with these values will throw an exception because are not present values category and macrocategory.

```php
$properties = [
    'subcategory' => 'beer',
];

Resource::box(
    $properties,
    $configurator
);
```

This request, instead, is valid.

```php

$properties = [
    'macrocategory' => 'beer',
    'category' => 'beer',
    'subcategory' => 'beer',
];

Resource::box(
    $properties,
    $configurator
);
```
