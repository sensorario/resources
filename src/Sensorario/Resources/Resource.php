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

use RuntimeException;
use Sensorario\Resources\Validators\ResourcesValidator;

class Resource
    extends MagicResource
    implements Interfaces\ResourceInterface
{
    protected $allowed = [];

    protected $allowedValues = [];

    protected $mandatory = [];

    protected $defaults = [];

    protected $rules = [];

    public function mandatory()
    {
        return $this->mandatory;
    }

    public function allowed()
    {
        return $this->allowed;
    }

    public function allowedValues()
    {
        return $this->allowedValues;
    }

    public function rules()
    {
        return $this->rules;
    }

    public function defaults()
    {
        return $this->defaults;
    }

    public function applyConfiguration(
        $resourceName,
        Container $container
    ) {
        $this->allowed       = $container->allowed($resourceName);
        $this->mandatory     = $container->mandatory($resourceName);
        $this->defaults      = $container->defaults($resourceName);
        $this->rules         = $container->rules($resourceName);
        $this->allowedValues = $container->allowedValues($resourceName);
    }

    public static function fromConfiguration(
        $resourceName,
        Container $container
    ) {
        $resource = new self(
            [],
            new ResourcesValidator(),
            $validationRequired = false
        );

        $resource->applyConfiguration(
            $resourceName,
            $container
        );

        return $resource;
    }
}
