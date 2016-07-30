<?php

namespace Sensorario\Resources;

final class Configurator 
{
    private $container;

    private $resourceName;

    private $ranges;

    public function __construct(
        $resourceName,
        Container $container
    ) {
        $this->resourceName = $resourceName;
        $this->container = $container;
    }

    public function allowed()
    {
        return $this->container->allowed(
            $this->resourceName
        );
    }

    public function mandatory()
    {
        return $this->container->mandatory(
            $this->resourceName
        );
    }

    public function defaults()
    {
        return $this->container->defaults(
            $this->resourceName
        );
    }

    public function rules()
    {
        return $this->container->rules(
            $this->resourceName
        );
    }

    public function allowedValues()
    {
        return $this->container->allowedValues(
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

    public function ranges()
    {
        return $this->container->ranges(
            $this->resourceName
        );
    }
}
