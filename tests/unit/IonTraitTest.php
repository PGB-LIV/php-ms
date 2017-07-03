<?php
/**
 * Copyright 2016 University of Liverpool
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace pgb_liv\php_ms\Test\Unit;

use pgb_liv\php_ms\Core\Spectra\IonTrait;

class IonTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMass
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassValid()
    {
        $value = 370.217742939639;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMass($value);
        
        $this->assertEquals($value, $spectra->getMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMass($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMassCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassChargeValid()
    {
        $value = 370.217742939639;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMassCharge($value);
        
        $this->assertEquals($value, $spectra->getMassCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMassCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMassCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setCharge
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetChargeValid()
    {
        $value = 5;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setCharge($value);
        
        $this->assertEquals($value, $spectra->getCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setIntensity
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getIntensity
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetIntensityValid()
    {
        $value = 3445.452411;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setIntensity($value);
        
        $this->assertEquals($value, $spectra->getIntensity());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setIntensity
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetIntensityInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setIntensity($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMass
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMass
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::calculateNeutralMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanGetMassFromMz()
    {
        $mass = 799.41405;
        $mz = 400.7143;
        $charge = 2;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMassCharge($mz);
        $spectra->setCharge($charge);
        
        $this->assertEquals($mass, round($spectra->getMass(), 5));
    }
}
