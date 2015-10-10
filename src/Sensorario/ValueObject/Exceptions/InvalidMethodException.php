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
 * Exception thrown when a method is called on value object, but is not yet defined
 */
final class InvalidMethodException extends Exception { }
