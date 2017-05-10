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

use pgb_liv\php_ms\Core\Spectra\PrecursorIon;

class SpectraEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setMass
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetMassValid()
    {
        $value = 370.217742939639;
        
        $spectra = new PrecursorIon();
        $spectra->setMass($value);
        
        $this->assertEquals($value, $spectra->getMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetMassInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setMass($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getMassCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetMassChargeValid()
    {
        $value = 370.217742939639;
        
        $spectra = new PrecursorIon();
        $spectra->setMassCharge($value);
        
        $this->assertEquals($value, $spectra->getMassCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setMassCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetMassChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setMassCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setCharge
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetChargeValid()
    {
        $value = 5;
        
        $spectra = new PrecursorIon();
        $spectra->setCharge($value);
        
        $this->assertEquals($value, $spectra->getCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setRetentionTime
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getRetentionTime
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetRetentionTimeValid()
    {
        $value = 51.5;
        
        $spectra = new PrecursorIon();
        $spectra->setRetentionTime($value);
        
        $this->assertEquals($value, $spectra->getRetentionTime());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setRetentionTime
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetRetentionTimeInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setRetentionTime($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setTitle
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getTitle
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetTitle()
    {
        $value = 'MySpectra 1.0324 with intensity 500000';
        
        $spectra = new PrecursorIon();
        $spectra->setTitle($value);
        
        $this->assertEquals($value, $spectra->getTitle());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setScan
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getScan
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetScansValid()
    {
        $value = 1000;
        
        $spectra = new PrecursorIon();
        $spectra->setScan($value);
        
        $this->assertEquals($value, $spectra->getScan());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setScan
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetScansInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setScan($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setIntensity
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getIntensity
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetIntensityValid()
    {
        $value = 3445.452411;
        
        $spectra = new PrecursorIon();
        $spectra->setIntensity($value);
        
        $this->assertEquals($value, $spectra->getIntensity());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setIntensity
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanSetIntensityInvalid()
    {
        $value = 'fail';
        
        $spectra = new PrecursorIon();
        $spectra->setIntensity($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::setMass
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getMass
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::calculateNeutralMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanGetMassFromMz()
    {
        $mass = 799.41405;
        $mz = 400.7143;
        $charge = 2;
        
        $spectra = new PrecursorIon();
        $spectra->setMassCharge($mz);
        $spectra->setCharge($charge);
        
        $this->assertEquals($mass, round($spectra->getMass(), 5));
    }
}
