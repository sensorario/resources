## Example


```php
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Helpers\JsonExporter;
use Sensorario\Resources\Resource;

$jsonResource = new JsonExporter(
  Resource::box(
    [ 'foo' => 'bar' ],
    new Configurator(
      'foo',
      new Container(
        [
          'resources' => [
            'foo' => [
              'constraints' => [
                'mandatory' => [
                  'foo',
                ]
              ]
            ]
          ]
        ]
      )
    )
  )
);

$curlHandler = curl_init();

curl_setopt($curlHandler, CURLOPT_URL, 'http://www.example.com');
curl_setopt($curlHandler, CURLOPT_POST, 1);
curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $jsonResource);

$curl_exec($curlHandler);

curl_close($curlHandler);
```
