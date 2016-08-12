# Overridable values

## Configurator part

Since version 4.1, is possible to define global configuration, to remove dedundance.

```php
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;

$configurator = new Configurator(
   'foo',
   new Container([
       'globals' => [
           'allowed' => [
               'width',
               'height',
           ],
       ],
       'resources' => [
           'foo' => [
               'constraints' => [
                   'allowed' => [
                       'foo_size',
                   ],
               ],
           ], 
           'bar' => [
               'constraints' => [
                   'allowed' => [
                       'bar_size',
                   ],
               ],
           ], 
       ],
   ])
);
```

## Usages

When more than one resource have same properties, is possibile to use a global configuration, that allow all resources to accept same values. In this example, foo resource allow only foo_size properties but inherit width and height from globals.

```php
use Sensorario\Resources\Resource;

$resource = Resource::box(
   [],
   $configurator
);

$this->assertEquals(
   ['foo_size', 'width', 'height'],
   $resource->allowed()
);
```

