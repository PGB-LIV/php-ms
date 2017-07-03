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
use pgb_liv\php_ms\Utility\Filter\FilterRetentionTime;

class FilterRetentionTimeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $filter = new FilterRetentionTime(10.0, 20.0);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterRetentionTime', $filter);
        
        return $filter;
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        new FilterRetentionTime('string', 300.0);
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        new FilterRetentionTime(1.0, array());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testCanValidateEntryInBounds()
    {
        $spectra = new PrecursorIon();
        $spectra->setRetentionTime(15.25);
        
        $filter = new FilterRetentionTime(10.0, 20.0);
        
        $this->assertTrue($filter->isValidSpectra($spectra));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testCanValidateEntryOnBounds()
    {
        $spectraLow = new PrecursorIon();
        $spectra->setRetentionTime(10.0);
        $spectraHigh = new PrecursorIon();
        $spectra->setRetentionTime(20.0);
        
        $filter = new FilterRetentionTime(10.0, 20.0);
        
        $this->assertTrue($filter->isValidSpectra($spectraLow));
        $this->assertTrue($filter->isValidSpectra($spectraHigh));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterRetentionTime::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterRetentionTime
     */
    public function testCanValidateEntryOutOfBounds()
    {
        $spectraLow = new PrecursorIon();
        $spectraLow->setMass(5.26);
        $spectraHigh = new PrecursorIon();
        $spectraHigh->setMass(734.86);
        
        $filter = new FilterRetentionTime(10.0, 20.0);
        
        $this->assertFalse($filter->isValidSpectra($spectraLow));
        $this->assertFalse($filter->isValidSpectra($spectraHigh));
    }
}
