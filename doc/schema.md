# Schemas

Starting from version 4.2, were introduced schema. Schema, is a Json-Schema inspired configuration of all reaquests.

```php
$schema = new Schema([
    'title' => 'this is the root schema',
    'type' => Schema::PRIMITIVE_DEFAULT,
    'properties' => [],
    'anotherSchema' => [
        'title' => 'this is subschema',
        'type' => Schema::PRIMITIVE_DEFAULT,
        'properties' => [],
        'otherSchema' => [
            'title' => 'this is other schema',
            'type' => Schema::PRIMITIVE_DEFAULT,
            'properties' => [],
        ],
    ],
]);
```

## Schema for response validation

If json response does not respect the schema, some exceptions will be thrown.

### before

Before Schema class, a Configurator, and a Container have been defined the resource.

```php
Resource::box([
  'name' => 'Simone',
  'surname' => 'Gentili',
  'user_type' => 'company',
  'vat_number' => '34534534555',
], $configurator);
```

### after

Now the schema is all we need to validate a json response.

```php
$schema = new Schema(/* array with schema*/);
$schema->validate($jsonResponse);
```

## Exceptions

 - `InvalidTypeException`
 - `MissingPropertyException`
 - `NoPropertiesException`
 - `NoPropertyTypeException`
 - `NotAllowedPropertyException`
 - `NotAllowedValueException`
 - `NoTypeException`
 - `UndefinedArrayTypeException`
