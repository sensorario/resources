<?php

namespace Sensorario\Resources;

use \RuntimeException;

/** @deprecate all these methods will be removed in version 5.0 */
class ContainerBase
{
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
