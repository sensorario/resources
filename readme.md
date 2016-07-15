# sensorario/resources

[![Issue Count](https://codeclimate.com/github/sensorario/resources/badges/issue_count.svg)](https://codeclimate.com/github/sensorario/resources) [![Code Climate](https://codeclimate.com/github/sensorario/resources/badges/gpa.svg)](https://codeclimate.com/github/sensorario/resources) [![Latest Stable Version](https://poser.pugx.org/sensorario/resources/v/stable)](https://packagist.org/packages/sensorario/resources) [![Total Downloads](https://poser.pugx.org/sensorario/resources/downloads)](https://packagist.org/packages/sensorario/resources) [![Latest Unstable Version](https://poser.pugx.org/sensorario/resources/v/unstable)](https://packagist.org/packages/sensorario/resources) [![License](https://poser.pugx.org/sensorario/resources/license)](https://packagist.org/packages/sensorario/resources)

## Example

The following request is incomplete, because `/user` resource, needs vat_number, if user_type is equals to `company`.

```php
/user
{
  "name" : "Simone",
  "surname" : "Gentili",
  "user_type" : "company",
}
```

With this library, a resource can be defined inside a container.

```php
new Container([
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
```

```php
$configurator = new Configurator('resource_name', new Container(…));

Resource::box([
  'name' => 'Simone',
  'surname' => 'Gentili',
  'user_type' => 'company',
  'vat_number' => '34534534555',
], $configurator);
```

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
