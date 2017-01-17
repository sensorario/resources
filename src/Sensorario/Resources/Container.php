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

class Container
{
    private $resources;

    private $rewrites;

    private $allowed = [
        'allowed',
        'allowedRanges',
        'allowedValues',
        'defaults',
        'mandatory',
        'rules',
    ];

    private $globals;

    public function __construct(array $resources)
    {
        if (!isset($resources['resources'])) {
            throw new RuntimeException(
                'resources element is not defined'
            );
        }

        $this->rewrites = [];
        $this->globals  = [];

        $this->ensureValidConstraints($resources);

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

    private function ensureValidConstraints($resources)
    {
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

        return true;
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

    public function mandatory($resource)
    {
        return $this->getConstraints(
            'mandatory',
            $resource
        );
    }

    public function defaults($resource)
    {
        return $this->getConstraints(
            'defaults',
            $resource
        );
    }

    public function rules($resource)
    {
        return $this->getConstraints(
            'rules',
            $resource
        );
    }

    public function allowedValues($resource)
    {
        return $this->getConstraints(
            'allowedValues',
            $resource
        );
    }

    public function ranges($resource)
    {
        return $this->getConstraints(
            'allowedRanges',
            $resource
        );
    }
}
