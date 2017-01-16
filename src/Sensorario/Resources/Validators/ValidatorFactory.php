<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Validators;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Sensorario\Resources\Validators\Interfaces\Validator;

class ValidatorFactory
{
    public static function fromName($name) : Validator
    {
        $validatorClass = 'Sensorario'
            .'\\Resources'
            .'\\Validators'
            .'\\Validators'
            .'\\' . $name;

        if ('RightType' == $name) {
            $validator = new EmailValidator();

            $multipleValidations = new MultipleValidationWithAnd([
                new RFCValidation(),
                new DNSCheckValidation()
            ]);

            return new $validatorClass(
                $validator,
                $multipleValidations
            );
        }

        return new $validatorClass();
    }
}
