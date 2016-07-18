## Define allowed properties

### Class definition 

You must define all allowed properties

```php
public static function allowed()
{
    return [
        'property_name',
    ];
}
```

so then, you can define your value with the syntax:

```php
YourValue::box([
    'property_name' => 'value',
]);
```

### Configurator class

```php
$configurator = new Configurator(
  'foo',
  new Container(
    'resources' => [
      'foo' => [
        'constraints' => [
          'allowed' => [
            'property_name',
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
