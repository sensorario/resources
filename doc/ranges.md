# Overridable values

## Configurator part

Since version 4.1 is possible to define a range of values available for a certain properties.

```php
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;

$configurator = new Configurator(
   'foo',
   new Container([
       'resources' => [
           'foo' => [
               'constraints' => [
                   'allowedRanges' => [
                       'age' => [
                            'more_than' => 3,
                            'less_than' => 42,
                       ],
                   ],
                   'allowed' => [
                       'age'
                   ],
               ],
           ],
       ],
   ])
);
```

## Usages

Trying to create a resource with 2, that is a value not in range 3-42, an exception will be thrown.

```php
use Sensorario\Resources\Resource;

Resource::box(
   [ 'age' => 2 ],
   $configurator
);
```
