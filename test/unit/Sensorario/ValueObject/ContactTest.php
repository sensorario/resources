<?php

/**
 * Redundant tests, just implemented as examples
 */

namespace Sensorario\ValueObject;

use PHPUnit_Framework_TestCase;
use Sensorario\ValueObject\Contact;

/**
 * The example
 */
final class ContactTest extends PHPUnit_Framework_TestCase
{
    /**
     * First exaple is the creation with the mandatory viewed_name field
     */
    public function testCreationWithVisualizedName()
    {
        Contact::createWithName([
            'viewed_name' => 'Demo',
        ]);
    }

    /**
     * We can also create indicanting a surname
     */
    public function testCreationWithVisualizedNameAndSurname()
    {
        Contact::createWithName([
            'viewed_name' => 'Demo',
            'surname'     => 'Gentili',
        ]);
    }

    /**
     * We can also create indicanting a name
     */
    public function testCreationWithVisualizedNameAndName()
    {
        Contact::createWithName([
            'viewed_name' => 'Demo',
            'name'        => 'Simone',
        ]);
    }

    /**
     * We can also create indicanting a nickname
     */
    public function testCreationWithVisualizedNameAndNickname()
    {
        Contact::createWithName([
            'viewed_name' => 'Demo',
            'nickname'    => 'Demo'
        ]);
    }

    public function testCustomCreation()
    {
        Contact::author();
    }
}
