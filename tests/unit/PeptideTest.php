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

use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Protein;
use pgb_liv\php_ms\Core\Modification;

class PeptideTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanConstructValid()
    {
        $peptide = new Peptide();
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Core\Peptide', $peptide);
        
        return $peptide;
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::__construct
     * @covers pgb_liv\php_ms\Core\Peptide::getSequence
     * @covers pgb_liv\php_ms\Core\Peptide::getLength
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetSequence()
    {
        $sequence = 'PEPTIDE';
        $peptide = new Peptide($sequence);
        
        $this->assertEquals($sequence, $peptide->getSequence());
        $this->assertEquals(strlen($sequence), $peptide->getLength());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getPositionStart
     * @covers pgb_liv\php_ms\Core\Peptide::setPositionStart
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetSetPositionStartValid()
    {
        $sequence = 'PEPTIDE';
        $start = 1;
        $peptide = new Peptide($sequence);
        $peptide->setPositionStart($start);
        
        $this->assertEquals($start, $peptide->getPositionStart());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::setPositionStart
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanSetPositionStartInvalidString()
    {
        $sequence = 'PEPTIDE';
        $start = 'fail';
        $peptide = new Peptide($sequence);
        $peptide->setPositionStart($start);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getPositionEnd
     * @covers pgb_liv\php_ms\Core\Peptide::setPositionEnd
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetSetPositionEndValid()
    {
        $sequence = 'PEPTIDE';
        $end = 1;
        $peptide = new Peptide($sequence);
        $peptide->setPositionEnd($end);
        
        $this->assertEquals($end, $peptide->getPositionEnd());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::setPositionEnd
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanSetPositionEndInvalidString()
    {
        $sequence = 'PEPTIDE';
        $end = 'fail';
        $peptide = new Peptide($sequence);
        $peptide->setPositionEnd($end);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getMissedCleavageCount
     * @covers pgb_liv\php_ms\Core\Peptide::setMissedCleavageCount
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetSetMissedCleavageCountValid()
    {
        $sequence = 'PEPTIDE';
        $cleavages = 1;
        $peptide = new Peptide($sequence);
        $peptide->setMissedCleavageCount($cleavages);
        
        $this->assertEquals($cleavages, $peptide->getMissedCleavageCount());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanSetMissedCleavageCountInvalidString()
    {
        $sequence = 'PEPTIDE';
        $cleavages = 'fail';
        $peptide = new Peptide($sequence);
        $peptide->setMissedCleavageCount($cleavages);
    }
    
    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getProtein
     * @covers pgb_liv\php_ms\Core\Peptide::setProtein
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetSetProteinValid()
    {
        $sequence = 'PEPTIDE';
        $protein = new Protein();
        $peptide = new Peptide($sequence);
        $peptide->setProtein($protein);
        
        $this->assertEquals($protein, $peptide->getProtein());
    }
    
    /**
     * @covers pgb_liv\php_ms\Core\Peptide::__clone
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanClone()
    {
        $sequence = 'PEPTIDE';
        $protein = new Protein();
        $peptide = new Peptide($sequence);
        $peptide->setProtein($protein);
        $modification = new Modification();
        $modification->setMonoisotopicMass(79.97);
        $peptide->addModification($modification);
        
        $peptideClone = clone $peptide;
        
        $this->assertEquals($peptideClone, $peptide);
    }
    
    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getMolecularFormula
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     */
    public function testCanGetMolecularFormula()
    {        
        $peptide = new Peptide('PEPTIDE');
        
        $this->assertEquals('C34H53N7O15', $peptide->getMolecularFormula());
    }
}
