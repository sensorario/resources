<?php

use Sensorario\Resources\Tools\Validator;

class ValidatorTest extends PHPUnit\Framework\TestCase
{
    public function testValidatorContainsNoErrorsWheneverJustInitialized()
    {
        $validator = new Validator();
        $this->assertNull($validator->error());
    }

    public function testAlwaysValidateEmptyData()
    {
        $validator = new Validator();
        $response = $validator->validate();
        $this->assertTrue($response->isValid());
    }

    public function testCantValidateDataIfNoConstraintsAreDefined()
    {
        $validator = new Validator();
        $validator->setData([
            'ciaone' => 'proprio',
        ]);
        $response = $validator->validate();
        $this->assertFalse($response->isValid());
    }

    public function testValidateDataWheneverRightConstraintsAreDefined()
    {
        $validator = new Validator();
        $validator->setData([
            'ciaone' => 'proprio',
        ]);
        $validator->setConstraints([
            'allowed' => [
                'ciaone',
            ],
        ]);
        $response = $validator->validate();
        $this->assertTrue($response->isValid());
    }
}
