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

use Sensorario\Resources\Resource;
use Sensorario\Resources\Rulers\Ruler;
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;

class RulerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Sensorario\Resources\Exceptions\InvalidCustomValidatorException
     * @expectedExceptionMessage Oops! `custom-validator` custom validator is not available. Only email is.
     */
    public function test()
    {
        $configurator = new Configurator(
            'foo',
            new Container([
                'resources' => [
                    'foo' => [
                        'constraints' => [
                            'allowed' => [
                                'property_name',
                            ],
                            'rules' => [
                                'property_name' => [
                                    'custom-validator' => 'foo',
                                ]
                            ]
                        ],
                    ],
                ]
            ])
        );

        Resource::box([
            'property_name' => '42',
        ], $configurator);
    }

    public function setUp()
    {
        $this->ruler = new Ruler();
    }

    /**
     * @expectedException \Sensorario\Resources\Exceptions\UndefinedResourceException
     * @expectedExceptionMessage Oops! Cant get rule without resource
     */
    public function testCantGetRuleWithoutRecource()
    {
        $this->ruler->getRuleFromResource();
    }
}
