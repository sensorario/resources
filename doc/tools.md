# Tools

Tools are a couple of classes used for validate an array. The validator class
return a response. The Validator api is very simple:

## Usage

```php
use Sensorario\Resources\Tools\Validator;
use Sensorario\Resources\Tools\Response;

$data = [
    'foo' => '42',
    //'bar' => '42',
];

$validator = new Validator();
$validator->setData($data);
$validator->setConstraints(array(
    'mandatory' => array(
        'foo',
        'bar'
    )
));

$response = $validator->validate();

if ($response->isValid()) {
    echo 'is valid';
} else {
    echo 'contains errors';
}
```

## Define DateTime type

```php
use Sensorario\Resources\Tools\Validator;
use Sensorario\Resources\Tools\Response;

$data = [
    //'foo' => new DateTime(),
    'foo' => 42,
];

$validator = new Validator();
$validator->setData($data);
$validator->setConstraints(array(
    'allowed' => [
        'foo',
    ],
    'rules' => array(
        'foo' => [
            'object' => 'DateTime',
        ]
    )
));

$response = $validator->validate();

if ($response->isValid()) {
    echo 'is valid';
} else {
    //    contains errors: Attribute `foo` must be of type `DateTime`
    echo 'contains errors: ' . $validator->error();
}
```
