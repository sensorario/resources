<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Interfaces;

use Sensorario\ValueObject\ValueObject;

interface Service
{
    public function __construct(ValueObject $valueObject);

    public function execute();
}
