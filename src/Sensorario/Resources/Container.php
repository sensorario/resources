<?php

namespace Sensorario\Resources;

use \RuntimeException;

class Container
    extends ContainerBase
{
    private $resources;

    private $allowed = [
        'allowed',
        'allowedRanges',
        'allowedValues',
        'defaults',
        'mandatory',
        'rules',
    ];

    private $rewrite = [];

    public function __construct(array $resources)
    {
        if (!isset($resources['resources'])) {
            throw new RuntimeException(
                'resources element is not defined'
            );
        }

        $this->rewrites = [];
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

        foreach ($resources['resources'] as $item) {
            if (isset($item['rewrite'])) {
                foreach ($item['rewrite'] as $field => $rewriteRule) {
                    $this->rewrites[$field] = $rewriteRule;
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

    public function getConstraints(
        $constraintName,
        $resource
    ) {
        if (isset($this->resources['resources'][$resource]['constraints'][$constraintName])) {
            return $this->resources['resources'][$resource]['constraints'][$constraintName];
        }

        return [];
    }

    public function rewrites()
    {
        return $this->rewrites;
    }

    public function globals()
    {
        return $this->globals;
    }
}
