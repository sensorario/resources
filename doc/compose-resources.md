## Compose resource

### Class definition

Also could be defined all allowed type for a property

```php
$composition = ComposedResources::box([
    'credentials' => Foo::box([
        'name' => 'Sam'
    ]),
]);
```

And `$composition->properties();` will results:

```php
array(
    'credentials' => array(
        'name' => 'Sam',
    )
);
```

