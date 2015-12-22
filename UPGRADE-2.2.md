# Upgrades in version 2.2

Some error messages are now improved and help during the development.

## mandatory values

Since version 2.1, mandatory values could be confirable via ValueObject::mandatory().

```php
final class CreatedUserEvent
{
    public static function mandatory()
    {
        return [
            'user_type'
        ];
    }
}
```

And also, we can tell which values can assume the mandatory value

```php
final class CreatedUserEvent
{
    public static function allowedValues()
    {
        return [
            'user_type' => [
                'bot',
                'human',
            ]
        ];
    }
}
```

In this particular case, suppose to have a special behavior: bot users must not have a username. But human? Human must have username. So, .. imagine to build this event, and think about a tool to say that username is mandatory when property user_type is equal to 'human'. With version 2.2 this is possibile with this syntax.

```php
final class CreatedUserEvent
{
    public static function mandatory()
    {
        return [
            'username' => [
                'when' => [
                    'property' => 'user_type',
                    'value' => 'human'
                ],
            ]
        ];
    }
}
```

If more than one values makes username mandatory, all can be listed as an array.

```php
final class CreatedUserEvent
{
    public static function mandatory()
    {
        return [
            'username' => [
                'when' => [
                    'property' => 'user_type',
                    'value' => [
                        'human',
                        'guest',
                    ]
                ],
            ]
        ];
    }
}
```

Finally, a new syntax for mandatory values.

```php
final class CreatedUserEvent
{
    public static function mandatory()
    {
        return [
            'username' => [
                'when' => [
                    'property' => 'user_type',
                    'condition' => 'is_present'
                ],
            ]
        ];
    }
}
```
