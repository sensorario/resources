<?php

namespace Sensorario\ValueObject\Interfaces;

use Sensorario\ValueObject\ValueObject;

interface Service
{
    public function __construct(ValueObject $valueObject);

    public function execute();
}
