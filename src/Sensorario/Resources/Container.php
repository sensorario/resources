<?php

namespace Sensorario\Resources;

use \RuntimeException;

class Container
{
    private $resources;

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
                    $allowed = [
                        'allowed',
                    ];

                    if (!in_array($name, $allowed)) {
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
        return $this->resources['resources'][$resource]['constraints']['allowed'];
    }
}
