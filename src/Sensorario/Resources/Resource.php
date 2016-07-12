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
    protected static $allowed = [];

    protected static $mandatory = [];

    protected static $defaults = [];

    protected static $rules = [];

    public static function mandatory()
    {
        return static::$mandatory;
    }

    public static function allowed()
    {
        return static::$allowed;
    }

    public static function allowedValues()
    {
        return [];
    }

    public static function rules()
    {
        return static::$rules;
    }

    public static function defaults()
    {
        return static::$defaults;
    }

    public function applyConfiguration(
        $resourceName,
        Container $config
    ) {
        static::$allowed   = $config->allowed($resourceName);
        static::$mandatory = $config->mandatory($resourceName);
        static::$defaults  = $config->defaults($resourceName);
        static::$rules     = $config->rules($resourceName);
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
