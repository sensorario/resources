# Define mandatory properties

## Class definition

Even if a property is allowed, thus could be mandatory. Mandatory properties are allowed by default. In the example above, we can see that hello field is mandatory, but only when world property is present (defined). And since version 2.2, is possibile to define a mandatory property when other property assume a particular value.

```php
public static function mandatory()
{
    return [
        'property_name',
        'hello' => [
            'when' => [
                'property' => 'world',
                'condition' => 'is_present',
            ]
        ],
        'foo' => [
            'when' => [
                'property' => 'property_name',
                'has_value' => 'bar',
            ]
        ]
    ];
}
```

## Configurator class

```php
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;

$configurator = new Configurator(
  'foo',
  new Container(
    'resources' => [
      'foo' => [
        'constraints' => [
          'mandatory' => [
            'property_name',
            'hello' => [
                'when' => [
                    'property' => 'world',
                    'condition' => 'is_present',
                ]
            ],
            'foo' => [
                'when' => [
                    'property' => 'property_name',
                    'has_value' => 'bar',
                ]
            ]
          ],
        ],
      ],
    ]
  )
);
```
