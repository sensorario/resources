# Value Obejct

To create a new value object, just

```php
use Sensorario\ValueObject\ValueObject;

final class YouValue extends ValueObject
{

}
```

## Define mandatory properties

You must define all mandatory properties. In the example above, we can see that hello fields is mandatory, but only when world parameter is present. And since version 2.2, is possibile to define a mandatory property when other property assume a particular value.

```php
public static function mandatory()
{
    return [
        'property_name',
        'hello' => [
            'if_present' => 'world',
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

Since version 2.2, were added new syntax

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

## Default value for a property

```php
public static function defaults()
{
    return [
        'property_name' => 'default_value',
    ];
}
```

## Define the type of the property

A property could be configured to be a scalar or an object

```php
public static function types()
{
    return [
        'date' => [
            'object' => 'DateTime',
        ]
    ];
}
```

```php
public static function types()
{
    return [
        'fields' => [
            'scalar' => 'array'
        ]
    ];
}
```

## Allowed values

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

## Compose value objects

Also could be defined all allowed type for a property

```php
$composition = ComposedValueObject::box([
    'credentials' => Foo::box([
        'name' => 'Sam'
    ]),
]);
```

And `$composition->properties();` will results:

```php
[
    'credentials' => [
        'name' => 'Sam',
    ]
];
```
