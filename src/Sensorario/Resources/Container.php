<?php

namespace Sensorario\Resources;

use \RuntimeException;

class Container
{
    private $resources;

    private $allowed = [
        'allowed',
        'allowedValues',
        'defaults',
        'mandatory',
        'rules',
    ];

    public function __construct(array $resources)
    {
        if (!isset($resources['resources'])) {
            throw new RuntimeException(
                'resources element is not defined'
            );
        }

        $this->globals  = [];

        foreach ($resources['resources'] as $item) {
            if (isset($item['constraints'])) {
                foreach ($item['constraints'] as $name => $value) {
                    if (!in_array($name, $this->allowed)) {
                        throw new RuntimeException(
                            'Invalid constraint: '
                            . 'name ' . $name
                            . '; value ' . $value
                        );
                    }
                }
            }
        }

        if (isset($resources['globals'])) {
            $this->globals = $resources['globals'];
        }

        $this->resources = $resources;
    }

    public function countResources()
    {
        return count(
            $this->resources['resources']
        );
    }

    public function create($resource, array $constraints)
    {
        foreach ($constraints as $name => $value) {
            if (!isset($this->resources['resources'][$resource]['constraints']['allowed'])) {
                throw new RuntimeException(
                    'Not allowed `' . $name . '` constraint with value `' . $value . '`'
                );
            }

            if (!in_array($name, $this->resources['resources'][$resource]['constraints']['allowed'])) {
                throw new RuntimeException(
                    'Not allowed `' . $name . '` constraint with value `' . $value . '`'
                );
            }
        }
    }

    public function allowed($resource)
    {
        $allowed = [];

        foreach ($this->allowed as $item) {
            if (isset($this->resources['resources'][$resource]['constraints'][$item])) {
                $allowed = array_merge(
                    $allowed,
                    $this->resources['resources'][$resource]['constraints'][$item]
                );
            }
        }

        return $allowed;
    }

    public function mandatory($resource)
    {
        if (isset($this->resources['resources'][$resource]['constraints']['mandatory'])) {
            return $this->resources['resources'][$resource]['constraints']['mandatory'];
        }

        return [];
    }

    public function defaults($resource)
    {
        if (isset($this->resources['resources'][$resource]['constraints']['defaults'])) {
            return $this->resources['resources'][$resource]['constraints']['defaults'];
        }

        return [];
    }

    public function rules($resource)
    {
        if (isset($this->resources['resources'][$resource]['constraints']['rules'])) {
            return $this->resources['resources'][$resource]['constraints']['rules'];
        }

        return [];
    }

    public function allowedValues($resource)
    {
        if (isset($this->resources['resources'][$resource]['constraints']['allowedValues'])) {
            return $this->resources['resources'][$resource]['constraints']['allowedValues'];
        }

        return [];
    }

    public function globals()
    {
        return $this->globals;
    }
}
