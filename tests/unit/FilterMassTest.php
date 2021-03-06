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

use pgb_liv\php_ms\Utility\Filter\FilterMass;
use pgb_liv\php_ms\Core\Spectra\PrecursorIon;
use pgb_liv\php_ms\Core\Peptide;

class FilterMassTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $filter = new FilterMass(400.0, 1000.0);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Filter\FilterMass', $filter);
        
        return $filter;
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        new FilterMass('string', 300.0);
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        new FilterMass(1.0, array());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidSpectra
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testCanValidateEntryInBounds()
    {
        $spectra = new PrecursorIon();
        $spectra->setMass(350.5);
        
        $filter = new FilterMass(300.0, 400.0);
        
        $this->assertTrue($filter->isValidSpectra($spectra));
        
        $peptide = new Peptide('PEP');
        $this->assertTrue($filter->isValidPeptide($peptide));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testCanValidateEntryOnBounds()
    {
        $spectraLow = new PrecursorIon();
        $spectraLow->setMass(300.0);
        $spectraHigh = new PrecursorIon();
        $spectraHigh->setMass(400.0);
        
        $filter = new FilterMass(300.0, 400.0);
        
        $this->assertTrue($filter->isValidSpectra($spectraLow));
        $this->assertTrue($filter->isValidSpectra($spectraHigh));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidSpectra
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidPeptide
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     */
    public function testCanValidateEntryOutOfBounds()
    {
        $spectraLow = new PrecursorIon();
        $spectraLow->setMass(300.0);
        $spectraHigh = new PrecursorIon();
        $spectraHigh->setMass(400.0);
        
        $filter = new FilterMass(325.0, 375.0);
        
        $this->assertFalse($filter->isValidSpectra($spectraLow));
        $this->assertFalse($filter->isValidSpectra($spectraHigh));
        
        $peptideLow = new Peptide('PE');
        $this->assertFalse($filter->isValidPeptide($peptideLow), 'Peptide mass ' . $peptideLow->getMass() . ' > 325.0');
        
        $peptideHigh = new Peptide('PEPTIDE');
        $this->assertFalse($filter->isValidPeptide($peptideHigh));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::__construct
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::isValidSpectra
     * @covers pgb_liv\php_ms\Utility\Filter\FilterMass::filterSpectra
     *
     * @uses pgb_liv\php_ms\Utility\Filter\FilterMass
     * @uses pgb_liv\php_ms\Utility\Filter\AbstractFilter
     */
    public function testCanValidateEntryArray()
    {
        $spectra = array();
        $spectra[0] = new PrecursorIon();
        $spectra[0]->setMass(250.0);
        $spectra[1] = new PrecursorIon();
        $spectra[1]->setMass(350.0);
        $spectra[2] = new PrecursorIon();
        $spectra[2]->setMass(450.0);
        
        $filter = new FilterMass(300.0, 400.0);
        
        $this->assertEquals(array(
            1 => $spectra[1]
        ), $filter->filterSpectra($spectra));
    }
}
