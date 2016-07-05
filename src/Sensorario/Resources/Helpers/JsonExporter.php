<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Helpers;

use Sensorario\Resources\Interfaces\Helper;
use Sensorario\Resources\Resource;

final class JsonExporter implements Helper
{
    private $resource;

    private $json = [];

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function execute()
    {
        foreach ($this->resource->properties() as $key => $value) {
            $this->json[$key] = $value;
        }

        return json_encode(
            $this->json
        );
    }
}
