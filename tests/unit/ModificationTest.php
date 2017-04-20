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
    public function testObjectCanGetSetValidMass()
    {
        $id = 21;
        $monoMass = 321.4621;
        $modification = new Modification($id);
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
    public function testObjectCanSetInvalidMass()
    {
        $id = 21;
        $monoMass = 'fail';
        $modification = new Modification($id);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setMonoisotopicMass($monoMass);
    }

    /**
     * @covers pgb_liv\php_ms\Core\Modification::setLocation
     * @covers pgb_liv\php_ms\Core\Modification::getLocation
     *
     * @uses pgb_liv\php_ms\Core\Modification
     */
    public function testObjectCanGetSetValidLocation()
    {
        $id = 21;
        $location = 6;
        $modification = new Modification($id);
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
        $id = 21;
        $location = 'fail';
        $modification = new Modification($id);
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
        $id = 21;
        $residues = array(
            'S',
            'T',
            'Y'
        );
        $modification = new Modification($id);
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
        $id = 21;
        $residues = array(
            'STY'
        );
        $modification = new Modification($id);
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
        $id = 21;
        $residues = array(
            'ST',
            'Y'
        );
        $modification = new Modification($id);
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
        $id = 21;
        $residues = array();
        $modification = new Modification($id);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Modification', $modification);
        
        $modification->setResidues($residues);
    }
}
