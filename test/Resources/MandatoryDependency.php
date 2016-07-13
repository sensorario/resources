<?php

/**
 * This file is part of sensorario/resources repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Resources;

use Sensorario\Resources\Resource;

final class MandatoryDependency extends Resource
{
    const FOO             = 'foo';
    const MELLO           = 'mello';
    const MANDATORY_MELLO = 'mandatory_mello';

    public function mandatory()
    {
        return [
            MandatoryDependency::FOO,
            MandatoryDependency::MELLO => [
                'when' => [
                    'property' => 'mandatory_mello',
                    'condition' => 'is_present',
                ]
            ],
        ];
    }

    public function allowed()
    {
        return [
            MandatoryDependency::FOO,
            MandatoryDependency::MELLO,
            MandatoryDependency::MANDATORY_MELLO,
        ];
    }
}
