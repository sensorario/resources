## Define allowed properties

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
