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
use Sensorario\Resources\Interfaces\ResourceInterface;

class Resource extends MagicResource implements ResourceInterface
{
    protected $allowed = [];

    protected $allowedValues = [];

    protected $mandatory = [];

    protected $defaults = [];

    protected $rules = [];

    protected $rewrites = [];

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

    public function rewrites()
    {
        return $this->rewrites;
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
        $this->rewrites      = $configurator->rewrites();
        $this->ranges        = $configurator->ranges();

        if ($configurator->globals()) {
            $globals = $configurator->globals();
            if (isset($globals['allowed'])) {
                $this->allowed = array_merge(
                    $this->allowed,
                    $globals['allowed']
                );
            }
        }
    }

    public function isRuleDefinedFor($ruleName)
    {
        return isset($this->rules()[$ruleName]);
    }

    public function isRuleNotDefinedFor($ruleName)
    {
        return !$this->isRuleDefinedFor($ruleName);
    }

    public function getRule($ruleName) : Rule
    {
        return Rule::fromArray(
            $this->rules()[$ruleName]
        );
    }

    public function isFieldNumeric($fieldName)
    {
        return is_numeric($this->get($fieldName));
    }

    public function isFieldString($fieldName)
    {
        return is_string($this->get($fieldName));
    }

    public function isFieldNumericButString($fieldName)
    {
        return $this->isFieldNumeric($fieldName)
            && $this->isFieldString($fieldName);
    }

    public function getFieldType($fieldName)
    {
        return gettype($this->get($fieldName));
    }
}
