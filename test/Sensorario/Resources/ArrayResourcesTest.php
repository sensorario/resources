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
use Sensorario\Resources\ArrayResources;

final class ArrayResourcesTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException        \RuntimeException
     */
    public function testConfigurationCannotBeEmpty()
    {
        $resources = new ArrayResources([]);
    }

    public function testNeedsResourcesAsRootElement()
    {
        $resources = new ArrayResources([
            'resources' => [],
        ]);

        $this->assertSame(
            0,
            $resources->countResources()
        );
    }

    public function testResourcesAreResourcesChild()
    {
        $resources = new ArrayResources([
            'resources' => [
                'foo' => [],
                'bar' => [
                    'constraints' => [],
                ],
            ],
        ]);

        $this->assertSame(
            2,
            $resources->countResources()
        );
    }

    /**
     * @expectedException              \RuntimeException
     * @expectedExceptionMessageRegExp /Invalid constraint/
     */
    public function testResourceDefinesConstraints()
    {
        $resources = new ArrayResources([
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
        $resources = new ArrayResources([
            'resources' => [
                'foo' => [
                    'constraints' => [
                    ],
                ],
            ],
        ]);

        $resources->create(
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
        $resources = new ArrayResources([
            'resources' => [
                'foo' => [
                    'constraints' => [
                        'allowed' => [
                        ]
                    ],
                ],
            ],
        ]);

        $resources->create(
            'foo', [
                'foo' => 'bar',
            ]
        );
    }
    public function testCon()
    {
        $resources = new ArrayResources([
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
            $resources->allowed('foo')
        );
    }
}
