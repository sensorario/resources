# Allowed values

## Class definition

Also could be defined all allowed type for a property

```php
public static function allowedValues()
{
    return [
        'someApiParameter' => [
            'hello',
            'world'
        ],
    ];
}
```

## Configurator class

```php
use sensorario\resources\configurator;
use sensorario\resources\container;
use sensorario\resources\resource;

$configurator = new Configurator(
  'foo',
  new Container(
    'resources' => [
      'foo' => [
        'constraints' => [
          'allowed' => [
            'property_name',
          ],
          'allowedValues' => [
            'property_name' => [
              4,
              7,
            ],
          ],
        ],
      ],
    ]
  )
);

Resource::box([
  'property_name' => 7,
], $configurator);
```
