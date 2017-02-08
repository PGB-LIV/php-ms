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

use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class SpectraEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMass
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getMass
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetMassValid()
    {
        $value = 370.217742939639;
        
        $spectra = new SpectraEntry();
        $spectra->setMass($value);
        
        $this->assertEquals($value, $spectra->getMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetMassInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setMass($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getMassCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetMassChargeValid()
    {
        $value = 370.217742939639;
        
        $spectra = new SpectraEntry();
        $spectra->setMassCharge($value);
        
        $this->assertEquals($value, $spectra->getMassCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMassCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetMassChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setMassCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetChargeValid()
    {
        $value = 5;
        
        $spectra = new SpectraEntry();
        $spectra->setCharge($value);
        
        $this->assertEquals($value, $spectra->getCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetChargeInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setRetentionTime
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getRetentionTime
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetRetentionTimeValid()
    {
        $value = 51.5;
        
        $spectra = new SpectraEntry();
        $spectra->setRetentionTime($value);
        
        $this->assertEquals($value, $spectra->getRetentionTime());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setRetentionTime
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetRetentionTimeInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setRetentionTime($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setTitle
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getTitle
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetTitle()
    {
        $value = 'MySpectra 1.0324 with intensity 500000';
        
        $spectra = new SpectraEntry();
        $spectra->setTitle($value);
        
        $this->assertEquals($value, $spectra->getTitle());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setScans
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getScans
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetScansValid()
    {
        $value = 1000;
        
        $spectra = new SpectraEntry();
        $spectra->setScans($value);
        
        $this->assertEquals($value, $spectra->getScans());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setScans
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetScansInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setScans($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setIntensity
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::getIntensity
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetIntensityValid()
    {
        $value = 3445.452411;
        
        $spectra = new SpectraEntry();
        $spectra->setIntensity($value);
        
        $this->assertEquals($value, $spectra->getIntensity());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setIntensity
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanSetIntensityInvalid()
    {
        $value = 'fail';
        
        $spectra = new SpectraEntry();
        $spectra->setIntensity($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setMassCharge
     * @covers pgb_liv\php_ms\Core\Spectra\SpectraEntry::setCharge
     *
     * @uses pgb_liv\php_ms\Core\Spectra\SpectraEntry
     */
    public function testCanGetMassFromMz()
    {
        $mass = 799.41405;
        $mz = 400.7143;
        $charge = 2;
        
        $spectra = new SpectraEntry();
        $spectra->setMassCharge($mz);
        $spectra->setCharge($charge);
        
        $this->assertEquals($mass, round($spectra->getMass(), 5));
    }
}
