<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\Resources\Test\Resources;

use PHPUnit\Framework\TestCase;
use Sensorario\Resources\Rulers\Rule;

class RuleTest extends TestCase
{
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage rule type is not defined
     */
    public function testIvalidInitializationThrowAndException()
    {
        $rule = Rule::fromArray([]);
    }

    public function test()
    {
        $rule = Rule::fromArray(
            $ruleConfiguration = [
                Rule::TYPE_OBJECT => [
                    '\DateTime',
                ]
            ]
        );

        $this->assertEquals(
            $ruleConfiguration,
            $rule->asArray()
        );
    }

    /**
     * @expectedException \Sensorario\Resources\Exceptions\InvalidTypeException
     * @expectedExceptionMessageRegex #Oops! Invalid configuration!!!Type `foo` is not valid.#
     */
    public function testInvalidTypeIsNotAllowed()
    {
        $rule = Rule::fromArray([
            'foo' => [ ]
        ]);

        $rule->ensureRuleNameIsValid();
    }

    public function testCheckFunctionReturnRuleValidityAsBoolean()
    {
        $rule = Rule::fromArray([
            'foo' => [ ]
        ]);

        $this->assertSame(
            false,
            $rule->isValid()
        );
    }

    public function testIs()
    {
        $rule = Rule::fromArray(
            $ruleConfiguration = [
                Rule::TYPE_OBJECT => [
                    '\DateTime',
                ]
            ]
        );

        $this->assertSame(
            true,
            $rule->is(Rule::TYPE_OBJECT)
        );
    }

    public function testIsNot()
    {
        $rule = Rule::fromArray(
            $ruleConfiguration = [
                Rule::TYPE_OBJECT => [
                    '\DateTime',
                ]
            ]
        );

        $this->assertSame(
            false,
            $rule->isNot(Rule::TYPE_OBJECT)
        );
    }
}
