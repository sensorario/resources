# Create resources

  Scenario: throw an exception when resource are not properly defined
    Given a resource with mandatory values
    When I define user_type as company
    And var_number is not defined
    Then an exception is thrown

The following request is incomplete, because `/user` resource, needs vat_number, if user_type is equals to `company`.

```php
/user
{
  "name" : "Simone",
  "surname" : "Gentili",
  "user_type" : "company",
}
```

## Class definition

Alternatively, a resource can be defined as class:

```php
final class User
{
  public function mandatory()
  {
    return [
      'name',
      'surname',
      'user_type',
      'vat_number' => [
        'when' => [
          'property' => 'user_type',
          'has_value' => 'company',
      ]
    ];
  }
}
```

## Configurator class

With this library, a resource can be defined inside a container.

```php
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;

$container = new Container([
  'resources' => [
    'users' => [
      'constraints' => [
        'mandatory' => [
          'name',
          'surname',
          'user_type',
          'vat_number' => [
            'when' => [
              'property' => 'user_type',
              'has_value' => 'company',
          ]
        ],
      ],
    ],
  ],
]);

$configurator = new Configurator(
  'resource_name',
  $container
);

Resource::box([
  'name' => 'Simone',
  'surname' => 'Gentili',
  'user_type' => 'company',
  'vat_number' => '34534534555',
], $configurator);
```
