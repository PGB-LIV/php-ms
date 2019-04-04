<?php
/**
 * Copyright 2019 University of Liverpool
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
use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Constant\ChemicalConstants;

class ModifiableSequenceTraitTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getLength
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanValidiateGetSetValidSequence()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';

        $mock->setSequence($sequence);

        $this->assertEquals($sequence, $mock->getSequence());
        $this->assertEquals(strlen($sequence), $mock->getLength());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getLength
     *
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanValidiateGetSetInvalidSequence()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPT134IDE';

        $mock->setSequence($sequence);

        $this->assertEquals($sequence, $mock->getSequence());
        $this->assertEquals(strlen($sequence), $mock->getLength());
    }

    /**
     *
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
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setIsDecoy
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanValidiateGetSetIsDecoyInvalid()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $mock->setIsDecoy(0);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetMass1()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;
        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
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
        $mass += ChemicalConstants::HYDROGEN_MASS * 2;
        $mass += ChemicalConstants::OXYGEN_MASS;

        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetModifiedMass1()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;

        $modificiation = new Modification();
        $modificiation->setMonoisotopicMass(79.97);
        $modificiation->setLocation(4);

        $mock->addModification($modificiation);
        $mass += $modificiation->getMonoisotopicMass();

        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetModifiedMass2()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;

        $modificiation = new Modification();
        $modificiation->setMonoisotopicMass(79.97);
        $modificiation->setResidues(array(
            'E'
        ));

        $mock->addModification($modificiation);
        $mass += $modificiation->getMonoisotopicMass() * 2;

        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetModifiedMass3()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;

        $modificiation = new Modification();
        $modificiation->setMonoisotopicMass(79.97);
        $modificiation->setResidues(array(
            'P'
        ));
        $modificiation->setPosition(Modification::POSITION_NTERM);

        $mock->addModification($modificiation);
        $mass += $modificiation->getMonoisotopicMass();

        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetModifiedMass4()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mass = 799.3599;

        $modificiation = new Modification();
        $modificiation->setMonoisotopicMass(79.97);
        $modificiation->setResidues(array(
            'E'
        ));
        $modificiation->setPosition(Modification::POSITION_CTERM);

        $mock->addModification($modificiation);
        $mass += $modificiation->getMonoisotopicMass();

        $this->assertEquals($mock->getMass(), $mock->getMonoisotopicMass(), '', 0.0001);
        $this->assertEquals($mass, $mock->getMonoisotopicMass(), '', 0.0001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::setSequence
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getMonoisotopicMassCharge
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testCanGetMassCharge()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $sequence = 'PEPTIDE';
        $mock->setSequence($sequence);
        $mz = 267.46064;

        $this->assertEquals($mz, $mock->getMonoisotopicMassCharge(3), '', 0.0001);
    }

    /**
     *
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
     *
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
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isModified
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetIsModified1()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $this->assertFalse($mock->isModified());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isModified
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanGetIsModified2()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $mod = new Modification();
        $mod->setMonoisotopicMass(146.14);
        $mod->setResidues(array(
            'M'
        ));

        $mock->addModification($mod);

        $this->assertTrue($mock->isModified());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::clearModifications
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::isModified
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanClearModifications()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $mod = new Modification();
        $mod->setMonoisotopicMass(146.14);
        $mod->setResidues(array(
            'M'
        ));

        $mock->addModification($mod);

        $this->assertTrue($mock->isModified());

        $mock->clearModifications();

        $this->assertFalse($mock->isModified());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::addModification
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::getModifications
     * @covers pgb_liv\php_ms\Core\ModifiableSequenceTrait::removeModification
     *
     * @uses pgb_liv\php_ms\Core\ModifiableSequenceTrait
     */
    public function testObjectCanRemoveModification()
    {
        $mock = $this->getMockForTrait('pgb_liv\php_ms\Core\ModifiableSequenceTrait');

        $mods = array();
        $mods[0] = new Modification();
        $mods[0]->setMonoisotopicMass(146.14);
        $mods[0]->setResidues(array(
            'M'
        ));

        $mods[1] = new Modification();
        $mods[2]->setMonoisotopicMass(79.97);
        $mods[3]->setResidues(array(
            'T'
        ));

        $mock->addModification($mods[0]);
        $mock->addModification($mods[1]);

        $this->assertEquals(2, count($mock->getModifications()));

        $mock->removeModification($mods[0]);

        $this->assertEquals(1, count($mock->getModifications()));
    }
}
