<?php

namespace Sensorario\Resources;

final class Configurator 
{
    private $container;

    private $resourceName;

    public function __construct(
        $resourceName,
        Container $container
    ) {
        $this->resourceName = $resourceName;
        $this->container = $container;
    }

    public function __call($method, $bar)
    {
         return $this->container->$method(
             $this->resourceName
         );
    }

    public function resourceName()
    {
        return $this->resourceName;
    }

    public function container()
    {
        return $this->container;
    }

    public function rewrites()
    {
        return $this->container->rewrites();
    }

    public function globals()
    {
        return $this->container->globals();
    }
}
