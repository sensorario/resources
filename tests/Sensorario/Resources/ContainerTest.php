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
use Sensorario\Resources\Container;

final class ContainerTest extends TestCase
{
    /**
     * @expectedException \Sensorario\Resources\Exceptions\EmptyConfigurationException
     * @expectedExceptionMessage resources element is not defined
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
     * @expectedException \Sensorario\Resources\Exceptions\InvalidConstraintException
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
     * @expectedException              \Sensorario\Resources\Exceptions\NotAllowedConstraintException
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

    public function testCreationSucceedReturnsTrue()
    {
        $container = new Container([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'allowed' => [
                            'foo'
                        ]
                    ],
                ],
            ],
        ]);

        $creationSucceed = $container->create(
            'foo', [
                'foo' => 'bar',
            ]
        );

        $this->assertSame(
            true,
            $creationSucceed
        );
    }
}
