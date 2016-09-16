<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Schema\Exceptions;

use Exception;

final class InvalidTypeException
    extends Exception
{
    protected $message = 'Schema type is not defined';
}
