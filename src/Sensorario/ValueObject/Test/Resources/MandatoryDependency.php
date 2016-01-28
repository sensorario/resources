<?php

/**
 * This file is part of sensorario/value-object repository
 *
 * (c) Simone Gentili <sensorario@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensorario\ValueObject\Resources;

use Sensorario\ValueObject\ValueObject;

final class MandatoryDependency extends ValueObject
{
    const FOO             = 'foo';
    const MELLO           = 'mello';
    const MANDATORY_MELLO = 'mandatory_mello';

    public static function mandatory()
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

    public static function allowed()
    {
        return [
            MandatoryDependency::FOO,
            MandatoryDependency::MELLO,
            MandatoryDependency::MANDATORY_MELLO,
        ];
    }
}
