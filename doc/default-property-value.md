# Default value for a property

## Class definition

```php
class MyResource
{
  public static function defaults()
  {
      return [
          'property_name' => 'default_value',
      ];
  }
}
```

## Configurator class

```php
$configurator = new Configurator(
  'foo',
  new Container(
    'resources' => [
      'foo' => [
        'constraints' => [
          'defaults' => [
            'property_name' => 'default_value',
          ],
        ],
      ],
    ]
  )
);

Resource::box([
  'property_name' => '42',
], $configurator);
```
