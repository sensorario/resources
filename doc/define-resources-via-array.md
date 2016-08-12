# Define resources via array

```php
use Sensorario\Resources\Container;

new Container([
  'resources' => [
    'resource_name' => [
      'constraints' => [
        'mandatory' => [],
        'allowed' => [],
        'allowedValues' => [],
        'defaults' => [],
        'rules' => [],
      ],
    ],
    …
  ],
  …
]);
```
