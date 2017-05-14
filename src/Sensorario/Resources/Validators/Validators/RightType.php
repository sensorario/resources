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

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Rulers\Rule;
use Sensorario\Resources\Rulers\Ruler;
use Sensorario\Resources\Validators\Interfaces\Validator;

final class RightType implements Validator
{
    private $validator;

    private $multi;

    public function __construct()
    {
        $this->validator = new EmailValidator();

        $this->validations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);
    }

    public function check(Resource $resource)
    {
        foreach ($resource->properties() as $key => $value) {
            if ($resource->isRuleNotDefinedFor($key)) {
                return;
            }

            $ruler = Ruler::fromResourceAndKey($resource, $key);

            $rule = $resource->getRule($key);

            $rule->ensureRuleNameIsValid();

            if ($rule->isCustom()) {
                $ruler->ensureRuleTypeIsEmail();

                $isValid = $this->validator->isValid(
                    $resource->get($key),
                    $this->validations
                );

                if (false === $isValid) {
                    throw new \Sensorario\Resources\Exceptions\EmailException(
                        'Oops! Invalid email address'
                    );
                }
            }

            $ruler->ensureTypeIsValid();
            $ruler->ensureClassIsValid();
        }
    }
}
