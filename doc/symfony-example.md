# Symfony Example

## Controller

A service can be injected inside a controller.

```php
mespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /** @Route("/", name="homepage") */
    public function indexAction(
        Request $request,
        \AppBundle\Services\RequestValidator $validator
    ) {
        if (!$validator->validate()) {
            return new JsonResponse([
                'message' => $validator->getLastErrorMessage(),
            ], 404);
        }

        return new JsonResponse([
            'request_content' => json_decode($request->getContent(), true),
        ]);
    }
}
```

And the service can handle current request and validate it. In this example is not use a configurator for the class, but with a lot of requests is necessary.

```php
namespace AppBundle\Services;

use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;

final class RequestValidator
{
    private $currentRequest;

    private $lastErrorMessage;

    public function __construct(
        \Symfony\Component\HttpFoundation\RequestStack $requestStack
    ) {
        $this->currentRequest = $requestStack->getCurrentRequest();
    }

    public function validate()
    {
        try {
            Resource::box(
                json_decode($this->currentRequest->getContent(), true),
                new Configurator(
                    $this->currentRequest->getPathInfo(),
                    new Container(array(
                        'resources' => array(
                            '/' => array(
                                'constraints' => array(
                                    'mandatory' => array(
                                        'location',
                                        'mq',
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
