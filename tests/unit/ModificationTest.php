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

use pgb_liv\php_ms\Core\Modification;

class ModificationTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        return $modification;
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setMonoisotopicMass
     * @covers pgb_liv\php_ms\Core\Modification::getMonoisotopicMass
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetValidMonoMass()
    {
        $monoMass = 321.4621;
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setMonoisotopicMass($monoMass);
        
        $this->assertEquals($monoMass, $modification->getMonoisotopicMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setMonoisotopicMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidMonoMass()
    {
        $monoMass = 'fail';
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setMonoisotopicMass($monoMass);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setAverageMass
     * @covers pgb_liv\php_ms\Core\Modification::getAverageMass
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetValidAvgMass()
    {
        $avgMass = 321.4621;
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setAverageMass($avgMass);
        
        $this->assertEquals($avgMass, $modification->getAverageMass());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setAverageMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidAvgMass()
    {
        $avgMass = 'fail';
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setAverageMass($avgMass);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setLocation
     * @covers pgb_liv\php_ms\Core\Modification::getLocation
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetValidLocation()
    {
        $location = 6;
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setLocation($location);
        
        $this->assertEquals($location, $modification->getLocation());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setLocation
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidLocation()
    {
        $location = 'fail';
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setLocation($location);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setResidues
     * @covers pgb_liv\php_ms\Core\Modification::getResidues
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetValidResidues()
    {
        $residues = array(
            'S',
            'T',
            'Y'
        );
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setResidues($residues);
        
        $this->assertEquals($residues, $modification->getResidues());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setResidues
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidResidues1()
    {
        $residues = array(
            'STY'
        );
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setResidues($residues);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setResidues
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidResidues2()
    {
        $residues = array(
            'ST',
            'Y'
        );
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setResidues($residues);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setResidues
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidResidues3()
    {
        $residues = array();
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setResidues($residues);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setResidues
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanSetInvalidResidues4()
    {
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $this->assertEquals(array(), $modification->getResidues());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setName
     * @covers pgb_liv\php_ms\Core\Modification::getName
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetName()
    {
        $name = 'Phospho';
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setName($name);
        
        $this->assertEquals($name, $modification->getName());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setType
     * @covers pgb_liv\php_ms\Core\Modification::getType
     * @covers pgb_liv\php_ms\Core\Modification::isFixed
     * @covers pgb_liv\php_ms\Core\Modification::isVariable
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetTypeFixed()
    {
        $type = Modification::TYPE_FIXED;
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setType($type);
        
        $this->assertEquals($type, $modification->getType());
        $this->assertTrue($modification->isFixed());
        $this->assertFalse($modification->isVariable());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setType
     * @covers pgb_liv\php_ms\Core\Modification::getType
     * @covers pgb_liv\php_ms\Core\Modification::isFixed
     * @covers pgb_liv\php_ms\Core\Modification::isVariable
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetTypeVariable()
    {
        $type = Modification::TYPE_VARIABLE;
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setType($type);
        
        $this->assertEquals($type, $modification->getType());
        $this->assertFalse($modification->isFixed());
        $this->assertTrue($modification->isVariable());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setPosition
     * @covers pgb_liv\php_ms\Core\Modification::getPosition
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetPositionValid()
    {
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $position = Modification::POSITION_ANY;
        $modification->setPosition($position);
        $this->assertEquals($position, $modification->getPosition());
        
        $position = Modification::POSITION_CTERM;
        $modification->setPosition($position);
        $this->assertEquals($position, $modification->getPosition());
        
        $position = Modification::POSITION_NTERM;
        $modification->setPosition($position);
        $this->assertEquals($position, $modification->getPosition());
        
        $position = Modification::POSITION_PROTEIN_CTERM;
        $modification->setPosition($position);
        $this->assertEquals($position, $modification->getPosition());
        
        $position = Modification::POSITION_PROTEIN_NTERM;
        $modification->setPosition($position);
        $this->assertEquals($position, $modification->getPosition());
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setPosition
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetPositionInvalid()
    {
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $position = 'fail';
        $modification->setPosition($position);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setAccession
     * @covers pgb_liv\php_ms\Core\Modification::getAccession
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetName()
    {
        $accession = 'UNIMOD:21';
        $modification = new Modification();
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setAccession($accession);
        
        $this->assertEquals($accession, $modification->getAccession());
    }
}
