<?php

namespace Sensorario\ValueObject;

use PHPUnit_Framework_TestCase;

final class HttpRequestTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $valueObject = GenericValueObject::box();

        echo var_express($valueObject, true);
    }
}
