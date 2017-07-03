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

use pgb_liv\php_ms\Core\ModifiableSequenceTrait;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Modification;

class ModifiableSequenceTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getLength
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanValidiateGetSetSequence()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $sequence = 'PEPTIDE';
        
        $mock->setSequence($sequence);
        
        $this->assertEquals($sequence, $mock->getSequence());
        $this->assertEquals(strlen($sequence), $mock->getLength());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setIsDecoy
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isDecoy
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanValidiateGetSetIsDecoy()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $mock->setIsDecoy(true);
        
        $this->assertTrue($mock->isDecoy());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetMass1()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;
        $this->assertEquals($mass, $mock->getMass(), '', 0.0001);
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetMass2()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $sequence = 'XBZ';
        $mock->setSequence($sequence);
        
        $mass = Peptide::AMINO_ACID_B_MASS;
        $mass += Peptide::AMINO_ACID_X_MASS;
        $mass += Peptide::AMINO_ACID_Z_MASS;
        $mass += Peptide::HYDROGEN_MASS * 2;
        $mass += Peptide::OXYGEN_MASS;
        
        $this->assertEquals($mass, $mock->getMass(), '', 0.0001);
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getModifications
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetSetValidModification()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $mods = array();
        $mods[0] = new Modification();
        $mods[0]->setMonoisotopicMass(146.14);
        $mods[0]->setResidues(array(
            'M'
        ));
        
        $mock->addModification($mods[0]);
        
        $this->assertEquals($mods, $mock->getModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModifications
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getModifications
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetSetValidModifications()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $mods = array();
        $mods[0] = new Modification();
        $mods[0]->setMonoisotopicMass(146.14);
        $mods[0]->setResidues(array(
            'M'
        ));
        
        $mods[1] = new Modification();
        $mods[1]->setMonoisotopicMass(146.14);
        $mods[1]->setResidues(array(
            'M'
        ));
        
        $mock->addModifications($mods);
        
        $this->assertEquals($mods, $mock->getModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isModified
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetIsModified1()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $this->assertEquals(false, $mock->isModified());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isModified
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetIsModified2()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');
        
        $mods = array();
        $mods[0] = new Modification();
        $mods[0]->setMonoisotopicMass(146.14);
        $mods[0]->setResidues(array(
            'M'
        ));
        
        $mock->addModification($mods[0]);
        
        $this->assertEquals(true, $mock->isModified());
    }
}