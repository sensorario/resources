<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Rulers;

use RuntimeException;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Validators\Interfaces\Validator;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

class Ruler
{
    private $resource;

    private $rule;

    private $fieldName;

    public function __construct(Resource $resource = null, $fieldName = null)
    {
        $this->resource = $resource;
        $this->fieldName = $fieldName;
    }

    public static function fromResourceAndKey(Resource $resource, $fieldName) : Ruler
    {
        return new static($resource, $fieldName);
    }

    public function getRuleFromResource()
    {
        if (!$this->resource) {
            throw new \RuntimeException(
                'Oops! Cant get rule without resource'
            );
        }

        $this->rule = $this->resource->getRule($this->fieldName);
    }

    private function isNotCustom()
    {
        $this->getRuleFromResource();

        return $this->rule->isNotCustom();
    }

    public function typeMismatch()
    {
        return $this->isNotCustom()
            && $this->resource->getFieldType($this->fieldName) !== $this->rule->getRuleType();
    }

    public function classMismatch()
    {
        return $this->isNotCustom()
            && !($this->resource->get($this->fieldName) instanceof \Sensorario\Resources\Resource)
            && get_class($this->resource->get($this->fieldName)) != $this->rule->getValue();
    }

    public function ensureTypeIsValid()
    {
        if ($this->typeMismatch()) {
            if ($this->resource->isFieldNumericButString($this->fieldName)) {
                throw new \RuntimeException(
                    'Property `'.$this->fieldName.'` must be an integer!'
                );
            }

            throw new RuntimeException(
                'Attribute `' . $this->fieldName
                . '` must be of type '
                . '`' . $this->rule->getExpectedType() . '`'
            );
        }
    }

    public function ensureClassIsValid()
    {
        if ($this->classMismatch()) {
            if ($this->rule->isValueNotAnObject()) {
                throw new RuntimeException(
                    'Attribute `' . $this->fieldName
                    . '` must be an object of type ' . $this->rule->getValue()
                );
            }
        }
    }

    public function ensureRuleTypeIsEmail()
    {
        if (!$this->rule) {
            $this->getRuleFromResource();
        }

        if ($this->rule->isNotMail()) {
            throw new \RuntimeException(
                'Oops! `'. $this->rule->getRuleType() .'` custom validator is not available. Only email is.'
            );
        }
    }
}
