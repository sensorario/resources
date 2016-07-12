<?php

namespace Sensorario\Resources;

use \RuntimeException;

class Container
{
    private $resources;

    private $allowed = [
        'allowed',
        'mandatory',
    ];

    public function __construct(array $resources)
    {
        if (!isset($resources['resources'])) {
            throw new RuntimeException(
                ''
            );
        }

        foreach ($resources['resources'] as $item) {
            if (isset($item['constraints'])) {
                foreach ($item['constraints'] as $name => $value) {
                    if (!in_array($name, $this->allowed)) {
                        throw new RuntimeException(
                            'Invalid constraint'
                        );
                    }
                }
            }
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
                    'Not allowed `' . $name . '` constraint'
                );
            }

            if (!in_array($name, $this->resources['resources'][$resource]['constraints']['allowed'])) {
                throw new RuntimeException(
                    'Not allowed `' . $name . '` constraint'
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
}
