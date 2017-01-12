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

use RuntimeException;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\Interfaces\Validator;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

final class RightType implements Validator
{
    private static $availableTypes = [
        'object',
        'scalar',
        'custom-validator',
    ];

    public static function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if (isset($resource->rules()[$key])) {
                $rule = $resource->rules()[$key];

                if (!in_array(key($rule), static::$availableTypes)) {
                    throw new \RuntimeException(
                        'Oops! Invalid configuration!!!'
                        . 'Type `' . key($rule) . '` is not valid. '
                        . 'Available types are ' . var_export(static::$availableTypes, true)
                    );
                }

                if (key($rule) != 'custom-validator' && gettype($resource->get($key)) !== key($rule)) {
                    $expectedType = isset($rule['object'])
                        ? $rule['object']
                        : 'undefined';

                    if (is_numeric($resource->get($key)) && is_string($resource->get($key))) {
                        throw new \RuntimeException(
                            'Property `'.$key.'` must be an integer!'
                        );
                    }

                    throw new RuntimeException(
                        'Attribute `' . $key
                        . '` must be of type `'
                        . (key($rule) == 'scalar' ? current($rule) : $expectedType)
                        . '` with value `' . $value . '`'
                    );
                }

                if (
                    key($rule) != 'custom-validator' &&
                    !($resource->get($key) instanceof \Sensorario\Resources\Resource) &&
                    get_class($resource->get($key)) != current($rule)
                ) {
                    if ('array' !== current($rule)) {
                        throw new RuntimeException(
                            'Attribute `' . $key
                            . '` must be an object of type ' . current($rule)
                        );
                    }
                }

                if (key($rule) == 'custom-validator') {
                    if ('email' != current($rule)) {
                        throw new \RuntimeException(
                            'Oops! `'.key($rule).'` custom validator is not available. Only email are.'
                        );
                    }

                    $validator = new EmailValidator();
                    $multipleValidations = new MultipleValidationWithAnd([
                        new RFCValidation(),
                        new DNSCheckValidation()
                    ]);

                    if (false == $validator->isValid($resource->get($key), $multipleValidations)) {
                        throw new \RuntimeException(
                            'Oops! Invalid email address'
                        );
                    }
                }
            }
        }
    }
}
