<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Exceptions;

use Exception;

/**
 * When someone try to get a propery that does not exists
 */
final class InvalidKeyOrValueException extends Exception { }
