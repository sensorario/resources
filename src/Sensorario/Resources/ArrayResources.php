<?php

namespace Sensorario\Resources;

use \RuntimeException;

final class ArrayResources
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
                    if (!in_array($name, [])) {
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
}
