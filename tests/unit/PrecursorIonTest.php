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
use pgb_liv\php_ms\Core\Spectra\FragmentIon;
use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Peptide;

class PrecursorIonTest extends \PHPUnit_Framework_TestCase
{

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
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::addFragmentIon
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getFragmentIons
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanGetSetFragmentIons()
    {
        $ion1 = new FragmentIon();
        $ion1->setMass(1258.42);
        
        $ion2 = new FragmentIon();
        $ion2->setMass(1258.27);
        
        $spectra = new PrecursorIon();
        $spectra->addFragmentIon($ion1);
        $spectra->addFragmentIon($ion2);
        
        $ions = $spectra->getFragmentIons();
        
        $this->assertEquals($ion1->getMass(), $ions[0]->getMass());
        $this->assertEquals($ion2->getMass(), $ions[1]->getMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::addFragmentIon
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getFragmentIons
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::clearFragmentIons
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanClearFragmentIons()
    {
        $spectra = new PrecursorIon();
        $spectra->addFragmentIon(new FragmentIon());
        $spectra->addFragmentIon(new FragmentIon());
        
        $this->assertEquals(2, count($spectra->getFragmentIons()));
        
        $spectra->clearFragmentIons();
        $this->assertEquals(0, count($spectra->getFragmentIons()));
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::addIdentification
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getIdentifications
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanGetSetIdentifications()
    {
        $identification1 = new Identification();
        $identification1->setPeptide(new Peptide('PEPTIDE'));
        
        $identification2 = new Identification();
        $identification2->setPeptide(new Peptide('FRED'));
        
        $spectra = new PrecursorIon();
        $spectra->addIdentification($identification1);
        $spectra->addIdentification($identification2);
        
        $identifications = $spectra->getIdentifications();
        
        $this->assertEquals($identification1->getPeptide(), $identifications[0]->getPeptide());
        $this->assertEquals($identification2->getPeptide(), $identifications[1]->getPeptide());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::addIdentification
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::getIdentifications
     * @covers pgb_liv\php_ms\Core\Spectra\PrecursorIon::clearIdentifications
     *
     * @uses pgb_liv\php_ms\Core\Spectra\PrecursorIon
     */
    public function testCanClearIdentifications()
    {
        $spectra = new PrecursorIon();
        $spectra->addIdentification(new Identification());
        $spectra->addIdentification(new Identification());
        
        $this->assertEquals(2, count($spectra->getIdentifications()));
        
        $spectra->clearIdentifications();
        $this->assertEquals(0, count($spectra->getIdentifications()));
    }
}