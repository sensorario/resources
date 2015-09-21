# Usages

## Example with mandatory fields

```php
use Sensorario\ValueObject\ValueObject;

final class OnlyMandatoryFields extends ValueObject
{
    public static function mandatory()
    {
        return ['foo'];
    }
}

$mandatory = OnlyMandatoryFields::createMe([
    'foo' => 'bar'
]);
```

## Example with mandatory fields but with default value

```php
use Sensorario\ValueObject\ValueObject;

final class MandatoryButDefaultFields extends ValueObject
{
    public static function mandatory()
    {
        return ['foo'];
    }

    public static function defaults()
    {
        return ['foo' => 'hello'];
    }
}

$defaults = MandatoryButDefaultFields::moooo();
```


