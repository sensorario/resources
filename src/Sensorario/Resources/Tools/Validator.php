<?php

namespace Sensorario\Resources\Tools;

use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;

class Validator
{
    private $data;

    private $constraints;

    private $error;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function setConstraints(array $constraints)
    {
        $this->constraints = $constraints;
    }

    public function validate()
    {
        try {
            Resource::box(
                $this->data,
                new Configurator(
                    'resource',
                    new Container(array(
                        'resources' => array(
                            'resource' => array(
                                'constraints' => $this->constraints
                            )
                        )
                    ))
                )
            );

            return Response::success();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            return Response::failure();
        }
    }

    public function error()
    {
        return $this->error;
    }
}
