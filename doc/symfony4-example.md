# Symfony Example

It is possible to configure a route name with constraints and just ask validator to validate requests.

## Configuration

This is a minimal configuration that expect a post var.

    'homepage' => array(
        'constraints' => array(
            'mandatory' => array(
                'name',
            )
        )
    )

## Controller

Inside the controller the only thing to do is to inject the validator.

```php
<?php

namespace App\Controller;

use App\Services\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /** @Route("/", name="homepage", methods={"POST"}) */
    public function addProduct(
        Request $request,
        Validator $validator
    )
    {
        if (!$validator->validate()) {
            return $this->json([
                'message' => $validator->getLastErrorMessage(),
            ], 400);
        }

        return $this->json([
            'success' => 'true',
        ], 200);
    }
}

```

Validator automatically use current request route name.

```php
<?php

namespace App\Services;

use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;
use Symfony\Component\HttpFoundation\RequestStack;

final class Validator
{
    private $currentRequest;

    private $lastErrorMessage;

    public function __construct(RequestStack $requestStack)
    {
        $this->currentRequest = $requestStack->getCurrentRequest();
    }

    public function validate()
    {
        try {
            Resource::box(
                $this->currentRequest->request->all(),
                new Configurator(
                    $this->currentRequest->get('_route'),
                    new Container(array(
                        'resources' => array(
                            'homepage' => array(
                                'constraints' => array(
                                    'mandatory' => array(
                                        'name',
                                    )
                                )
                            )
                        )
                    ))
                )
            );
        } catch (\Exception $exception) {
            $this->lastErrorMessage = $exception->getMessage();
            return false;
        }

        return true;
    }

    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }
}
```
