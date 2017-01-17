<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources;

/**
 * @method array allowed() provide resource's allowed parameters
 * @method array allowedValues() provide resource's allowed values parameters
 * @method array mandatory() provide resource's mandatory parameters
 * @method array defaults() provide resource's default parameters
 * @method array rules() provide resource's rules
 */
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
