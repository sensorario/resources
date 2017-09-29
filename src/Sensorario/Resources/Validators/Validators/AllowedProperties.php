<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators\Validators;

use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\Interfaces\Validator;

final class AllowedProperties implements Validator
{
    private $resource;

    private $allowed;

    public function check(Resource $resource)
    {
        $this->resource = $resource;
        $this->buildAllowedProperties();
        if (null === $this->checkShouldBeSkipped()) {
            $this->ensurePropertyIsAllowed();
        }
    }

    private function buildAllowedProperties()
    {
        $this->allowed = array_merge(
            $this->resource->allowed(),
            $this->resource->mandatory()
        );
    }

    private function checkShouldBeSkipped()
    {
        foreach ($this->allowed as $kk => $vv) {
            if ($this->mustSkip($kk, $vv)) {
                return true;
            }
        }
    }

    public function ensurePropertyIsAllowed()
    {
        foreach ($this->resource->properties() as $key => $value) {
            if (!in_array($key, $this->allowed)) {
                throw new \Sensorario\Resources\Exceptions\NotAllowedKeyException(
                    "Key `" . get_class($this->resource) . "::\$$key` with value `" . $value . "` is not allowed"
                );
            }
        }
    }

    public function mustSkip($key, $value)
    {
        return !is_numeric($key) &&
            isset($value['when']) &&
            $this->resource->hasProperty($value['when']['property']);
    }
}
