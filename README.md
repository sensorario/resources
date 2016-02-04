# Value Obejct

To create a new value object, extends Sensorario\ValueObject\ValueObject abstract class.

```php
use Sensorario\ValueObject\ValueObject;

final class MyValue extends ValueObject
{

}
```

## Define mandatory properties

You can define mandatory properties. Mandatory properties are allowed by default. In the example above, we can see that hello field is mandatory, but only when world property is present (defined). And since version 2.2, is possibile to define a mandatory property when other property assume a particular value.

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

Since version 2.2, were added new syntax to define mandatory property. In version 2.2, `if_present` clause will be removed. Only `when` clause will remain.

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
array(
    'credentials' => array(
        'name' => 'Sam',
    )
);
```

## Usages

This library is used in sensorario/value-objects repository. A repository made to keep separated a real usage from this library.
