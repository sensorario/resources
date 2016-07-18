## Define the type of the property

### Class definition

A property could be configured to be a scalar or an object

```php
public static function rules()
{
    return [
        'date' => [
            'object' => 'DateTime',
        ]
    ];
}
```

```php
public static function rules()
{
    return [
        'fields' => [
            'scalar' => 'array'
        ]
    ];
}
```
