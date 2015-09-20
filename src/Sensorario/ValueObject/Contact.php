<?php

/**
 * Use this for a Contact list, or just for user
 *
 * @author Simone Gentili
 */

/**
 * @author Simone Gentili
 */
namespace Sensorario\ValueObject;

final class Contact extends ValueObject
{
    /**
     * Mandatory properties.
     *
     * A contact could be a person or a company, but alwau
     *
     * @return array the array of mandatory properties
     */
    protected static function mandatory()
    {
        return [
            'viewed_name',
        ];
    }

    /**
     * Allowed properties.
     * This method returns the array corresponding to the list of all allowed properties.
     *
     * @return array the array of allowed properties
     */
    protected static function allowed()
    {
        return [
            'name',
            'surname',
            'nickname',
        ];
    }

    /**
     * Author of this library
     *
     * Just an example of a custom builder
     */
    public static function author()
    {
        return new self([
            'name'        => 'Simone',
            'nickname'    => 'Demo',
            'surname'     => 'Gentili',
            'viewed_name' => 'Simone (Demo) Gentili',
        ]);
    }
}
