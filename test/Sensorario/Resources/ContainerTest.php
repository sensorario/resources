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

use PHPUnit_Framework_TestCase;
use Sensorario\Resources\Container;

final class ContainerTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        \RuntimeException
     */
    public function testConfigurationCannotBeEmpty()
    {
        $container = new Container([]);
    }

    public function testNeedsResourcesAsRootElement()
    {
        $container = new Container([
            'resources' => [],
        ]);

        $this->assertSame(
            0,
            $container->countResources()
        );
    }

    public function testResourcesAreResourcesChild()
    {
        $container = new Container([
            'resources' => [
                'foo' => [],
                'bar' => [
                    'constraints' => [],
                ],
            ],
        ]);

        $this->assertSame(
            2,
            $container->countResources()
        );
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp /Invalid constraint/
     */
    public function testResourceDefinesConstraints()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'invalid' => 'constraint',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp /Not allowed `foo` constraint/
     */
    public function testCannotCreateResourceWithoutAllowedConstraints()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                    ],
                ],
            ],
        ]);

        $container->create(
            'foo', [
                'foo' => 'bar',
            ]
        );
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp /Not allowed `foo` constraint/
     */
    public function test()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'allowed' => [
                        ]
                    ],
                ],
            ],
        ]);

        $container->create(
            'foo', [
                'foo' => 'bar',
            ]
        );
    }

    public function testCon()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'allowed' => [
                            'foo',
                            'bar',
                        ]
                    ],
                ],
            ],
        ]);

        $this->assertEquals( [
                'foo',
                'bar',
            ],
            $container->allowed('foo')
        );
    }

    public function testRewriteRules()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'rewrite' => [
                        'foo' => [
                            'set' => [
                                'equals_to' => 'bar',
                            ],
                            'when' => [
                                'greater_than' => 'bar',
                            ],
                        ],
                    ],
                    'constraints' => [
                        'allowed' => [
                            'foo',
                            'bar',
                        ]
                    ],
                ],
            ],
        ]);

        $this->assertEquals( [
                'foo' => [
                    'set' => [
                        'equals_to' => 'bar',
                    ],
                    'when' => [
                        'greater_than' => 'bar',
                    ],
                ],
            ],
            $container->rewrites('foo')
        );
    }
}
