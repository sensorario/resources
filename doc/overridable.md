# Overridable values

## Configurator part

Since version 4.1, is possible to define some rules able to override some values in specific conditions

```php
$configurator = new Configurator(
   'foo',
   new Container([
       'resources' => [
           'foo' => [
               'rewrite' => [
                    'width' => [
                        'set' => [
                            'equals_to' => 'height',
                        ],
                        'when' => [
                            'greater_than' => 'height',
                        ],
                    ],
               ],
               'constraints' => [
                   'allowed' => [
                       'width',
                       'height',
                   ],
               ],
           ], 
       ],
   ])
);
```

## Usages

This override rule, rewrite width when is greater than height. In this case, with must be equals to height. Here, we try to create a box with width and height defined. But the rule, override the Resource.
       …
```php
$properties = [
    'width'  => 3000,
    'height' => 400,
];

$box = Resource::box(
    $properties,
    $configurator
);
```

Will generate same resource of this code.

       …
```php
$properties = [
    'width'  => 400,
    'height' => 400,
];

$box = Resource::box(
    $properties,
    $configurator
);
```

