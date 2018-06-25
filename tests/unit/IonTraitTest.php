<?php
/**
 * Copyright 2018 University of Liverpool
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

class IonTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMonoisotopicMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassValid()
    {
        $value = 370.217742939639;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMonoisotopicMass($value);
        
        $this->assertEquals($value, $spectra->getMonoisotopicMass());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMonoisotopicMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMonoisotopicMass($value);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMonoisotopicMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMonoisotopicMassCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassChargeValid()
    {
        $mz = 370.217742939639;
        $charge = 2;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMonoisotopicMassCharge($mz, 2);
        
        $this->assertEquals($mz, $spectra->getMonoisotopicMassCharge(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMonoisotopicMassCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanSetMassChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMonoisotopicMassCharge($value, 10);
    }

    /**
     *
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
     *
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
     *
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::setMonoisotopicMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\IonTrait::getMonoisotopicMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\IonTrait
     */
    public function testCanGetMassFromMz()
    {
        $mass = 799.41405;
        $mz = 400.7143;
        $charge = 2;
        
        $spectra = $this->getMockForTrait('pgb_liv\php_ms\Core\Spectra\IonTrait');
        $spectra->setMonoisotopicMassCharge($mz, $charge);
        
        $this->assertEquals($mass, $spectra->getMonoisotopicMass(), '', 0.0001);
    }
}
