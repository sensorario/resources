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

    private $resourceConstraints;

    public function __construct(array $resources)
    {
        $this->ensureResourcesItemIsDefined($resources);

        $this->rewrites = [];
        $this->globals  = [];

        $this->ensureValidConstraints($resources);

        $this->fillInRewrites($resources['resources']);

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
                    $this->ensureNameIsAllowed($name, $value);
                }
            }
        }
    }

    public function ensureNameIsAllowed($name, $value)
    {
        if (!in_array($name, $this->allowed)) {
            throw new \Sensorario\Resources\Exceptions\InvalidConstraintException(
                'Invalid constraint: '
                . 'name ' . $name
                . '; value ' . $value
            );
        }
    }

    public function countResources()
    {
        return count(
            $this->resources['resources']
        );
    }

    private function getResourceConstraints($resource)
    {
        if (!$this->resourceConstraints) {
            $this->resourceConstraints = $this->resources['resources'][$resource]['constraints'];
        }

        return $this->resourceConstraints;
    }

    public function create($resource, array $constraints)
    {
        foreach ($constraints as $name => $value) {
            if (
                !isset($this->getResourceConstraints($resource)['allowed'])
                || !in_array($name, $this->getResourceConstraints($resource)['allowed'])
            ) {
                throw new \Sensorario\Resources\Exceptions\NotAllowedConstraintException(
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
            if (isset($this->getResourceConstraints($resource)[$item])) {
                $allowed = array_merge(
                    $allowed,
                    $this->getResourceConstraints($resource)[$item]
                );
            }
        }

        return $allowed;
    }

    public function getConstraints($constraint, $resource) : array
    {
        if (isset($this->getResourceConstraints($resource)[$constraint])) {
            return $this->getResourceConstraints($resource)[$constraint];
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

    public function ensureResourcesItemIsDefined($resources)
    {
        if (!isset($resources['resources'])) {
            throw new \Sensorario\Resources\Exceptions\EmptyConfigurationException(
                'resources element is not defined'
            );
        }
    }

    public function fillInRewrites(array $resources)
    {
        foreach ($resources as $item) {
            if (isset($item['rewrite'])) {
                foreach ($item['rewrite'] as $field => $rewriteRule) {
                    $this->rewrites[$field] = $rewriteRule;
                }
            }
        }
    }
}
