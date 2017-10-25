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
     * @covers pgb_liv\php_ms\Core\Peptide::__construct
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
     * @covers pgb_liv\php_ms\Core\Peptide::getProteins
     * @covers pgb_liv\php_ms\Core\Peptide::addProtein
     * @covers pgb_liv\php_ms\Core\Peptide::addProteinEntry
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::__construct
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry
     */
    public function testCanGetAddProteinValid()
    {
        $sequence = 'PEPTIDE';
        $protein = new Protein();
        $peptide = new Peptide($sequence);
        $peptide->addProtein($protein);
        
        $this->assertEquals($protein, $peptide->getProteins()[0]->getProtein());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getProteins
     * @covers pgb_liv\php_ms\Core\Peptide::addProtein
     * @covers pgb_liv\php_ms\Core\Peptide::addProteinEntry
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::setStart
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::getStart
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry
     */
    public function testCanGetAddProteinStartValid()
    {
        $sequence = 'PEPTIDE';
        $protein = new Protein();
        $start = 12;
        
        $peptide = new Peptide($sequence);
        $peptide->addProtein($protein, $start);
        
        $this->assertEquals($protein, $peptide->getProteins()[0]->getProtein());
        $this->assertEquals($start, $peptide->getProteins()[0]->getStart());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Peptide::getProteins
     * @covers pgb_liv\php_ms\Core\Peptide::addProtein
     * @covers pgb_liv\php_ms\Core\Peptide::addProteinEntry
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::setStart
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::getStart
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::setEnd
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry::getEnd
     *
     * @uses pgb_liv\php_ms\Core\Peptide
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ProteinEntry
     */
    public function testCanGetAddProteinEndValid()
    {
        $sequence = 'PEPTIDE';
        $protein = new Protein();
        $peptide = new Peptide($sequence);
        $start = 12;
        $end = 12;
        
        $peptide->addProtein($protein, $start, $end);
        
        $this->assertEquals($protein, $peptide->getProteins()[0]->getProtein());
        $this->assertEquals($start, $peptide->getProteins()[0]->getStart());
        $this->assertEquals($end, $peptide->getProteins()[0]->getEnd());
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
        $peptide->addProtein($protein);
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
