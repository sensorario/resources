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
use Sensorario\Resources\Configurator;
use Sensorario\Resources\Container;
use Sensorario\Resources\Resource;
use Sensorario\Resources\Rulers\Ruler;

class RulerTest extends TestCase
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
