<?php

/**
 * This file is part of sensorario/resources epository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Interfaces;

use Sensorario\Resources\Resource;

interface Helper
{
    public function __construct(Resource $resource);

    public function execute();
}
