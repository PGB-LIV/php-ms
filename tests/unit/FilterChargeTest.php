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

use pgb_liv\php_ms\Utility\Filter\FilterCharge;
use pgb_liv\php_ms\Core\Spectra\SpectraEntry;

class FilterChargeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterCharge::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterCharge
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $filter = new FilterCharge(1, 3);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterCharge', $filter);
        
        return $filter;
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterCharge::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterCharge
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        new FilterCharge('string', 3);
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterCharge::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterCharge
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        new FilterCharge(1, array());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterCharge::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterCharge::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterCharge
     */
    public function testCanValidateEntryInBounds()
    {
        $spectra = new SpectraEntry();
        $spectra->setCharge(2);
        
        $filter = new FilterCharge(1, 3);
        
        $this->assertEquals(true, $filter->isValidSpectra($spectra));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testCanValidateEntryOnBounds()
    {
        $spectraLow = new SpectraEntry();
        $spectraLow->setCharge(1);
        $spectraHigh = new SpectraEntry();
        $spectraHigh->setCharge(3);
        
        $filter = new FilterCharge(1, 3);
        
        $this->assertEquals(true, $filter->isValidSpectra($spectraLow));
        $this->assertEquals(true, $filter->isValidSpectra($spectraHigh));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValid
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     */
    public function testCanValidateEntryOutOfBounds()
    {
        $spectraLow = new SpectraEntry();
        $spectraLow->setCharge(1);
        $spectraHigh = new SpectraEntry();
        $spectraHigh->setCharge(5);
        
        $filter = new FilterCharge(2, 4);
        
        $this->assertEquals(false, $filter->isValidSpectra($spectraLow));
        $this->assertEquals(false, $filter->isValidSpectra($spectraHigh));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::isValidSpectra
     * @covers pgb_liv\php_ms\Utility\Filter\FilterLength::filterSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterLength
     * @uses pgb_liv\php_ms\Utility\Filter\AbstractFilter
     */
    public function testCanValidateEntryArray()
    {
        $spectra = array();
        $spectra[0] = new SpectraEntry();
        $spectra[0]->setCharge(1);
        $spectra[1] = new SpectraEntry();
        $spectra[1]->setCharge(3);
        $spectra[2] = new SpectraEntry();
        $spectra[2]->setCharge(5);
        
        $filter = new FilterCharge(2, 4);
        
        $this->assertEquals(array(
            1 => $spectra[1]
        ), $filter->filterSpectra($spectra));
    }
}
