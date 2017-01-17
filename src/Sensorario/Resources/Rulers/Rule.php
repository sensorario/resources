<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources;

class Rule
{
    const TYPE_OBJECT = 'object';

    const TYPE_SCALAR = 'scalar';

    const TYPE_CUSTOM = 'custom-validator';

    private static $avalableRuleTypes = [
        self::TYPE_OBJECT,
        self::TYPE_SCALAR,
        self::TYPE_CUSTOM,
    ];

    private $rule;

    private function __construct(array $rule) 
    {
        $this->rule = $rule;
    }

    public static function fromArray(array $rule)
    {
        if ([] === $rule) {
            throw new \LogicException(
                'rule type is not defined'
            );
        }

        return new self($rule);
    }

    public function ensureRuleNameIsValid()
    {
        if (!$this->isValid()) {
            throw new \RuntimeException(
                'Oops! Invalid configuration!!!'
                . 'Type `' . key($this->rule) . '` is not valid. '
                . 'Available types are ' . var_export(self::$avalableRuleTypes, true)
            );
        }
    }

    public function asArray() : array
    {
         return $this->rule;
    }

    public function isValid()
    {
        return in_array(key($this->rule), self::$avalableRuleTypes);
    }

    public function is($type)
    {
        return key($this->rule) === $type;
    }

    public function isNot($type)
    {
        return !$this->is($type);
    }

    public function isCustom()
    {
        return $this->is(Rule::TYPE_CUSTOM);
    }

    public function isNotCustom()
    {
        return !$this->isCustom();
    }

    public function isNotMail()
    {
        return 'email' != $this->getValue();
    }

    public function getRuleType()
    {
        return key($this->rule);
    }

    public function isObject()
    {
        return isset($this->rule[self::TYPE_OBJECT]);
    }

    public function getObjectType()
    {
        return $this->rule[self::TYPE_OBJECT];
    }

    public function getValue()
    {
        return current($this->rule);
    }

    public function getExpectedType()
    {
        $expectedType = $this->isObject()
            ? $this->getObjectType()
            : 'undefined';

        return $this->getRuleType() == self::TYPE_SCALAR
            ? $this->getValue()
            : $expectedType;
    }

    public function isValueNotAnObject()
    {
        return 'array' !== $this->getValue();
    }
}
