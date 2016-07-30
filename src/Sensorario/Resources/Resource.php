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

    protected $ranges = [];

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

    public function ranges()
    {
        return $this->ranges;
    }

    public function applyConfiguration(
        Configurator $configurator
    ) {
        $this->allowed       = $configurator->allowed();
        $this->mandatory     = $configurator->mandatory();
        $this->defaults      = $configurator->defaults();
        $this->rules         = $configurator->rules();
        $this->allowedValues = $configurator->allowedValues();
        $this->ranges        = $configurator->ranges();
    }
}
