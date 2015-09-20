# Value Obejct

## Generate documentation

    $ ./rundocs

## Run tests

    $ ./runtests

## Usage

Creation of a value object is very very simple

```php
use Sensorario\ValueObject\ValueObject;

final class Foo extends ValueObject
{
    public static function mandatory()
    {
        return [
            'foo',
        ];
    }

    public static function allowed()
    {
        return [
            'foo',
        ];
    }

    public static function defaults()
    {
        return [
            'foo' => 'bar',
        ];
    }

    public static function customFactory()
    {
        return new self([
            'foo' => 'bar',
        ]);
    }
}
```

```php
$customValueType = Foo::customFactory();
$helloFoo = $customValueType->foo('hello');
```
