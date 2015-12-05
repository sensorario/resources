# Upgrade from 2.0 to 2.1

In version 2.0 was not possibile to combine more Value Objects, But this feature is available since version 2.1.

```php
$composition = ComposedValueObject::box([
    'credentials' => Foo::box([
        'name' => 'Sam'
    ]),
]);
```

$composition->properties()
```php
[
    'credentials' => [
        'name' => 'Sam',
    ]
],
```
