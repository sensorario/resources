<?php

namespace Sensorario\Resources\Tools;

class Response
{
    private $params;

    private function __construct(array $params)
    {
        $this->params = $params;
    }

    public static function success()
    {
        return new self([
            'success' => true,
        ]);
    }

    public static function failure()
    {
        return new self([
            'success' => false,
        ]);
    }

    public function isValid()
    {
        return $this->params['success'] == true;
    }
}
