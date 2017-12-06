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

use pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry;
use pgb_liv\php_ms\Core\Protein;

class ChromosomeProteinEntryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanConstructValid()
    {
        $protein = new Protein();
        $chromosome = new ChromosomeProteinEntry($protein);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry', $chromosome);
        $this->assertEquals($protein, $chromosome->getProtein());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomeBlockCount
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::getChromosomeBlockCount
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetBlockCountValid()
    {
        $value = 10;
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomeBlockCount($value);
        
        $this->assertEquals($value, $chromosome->getChromosomeBlockCount());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomeBlockCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetBlockCountInvalid()
    {
        $value = 'fail';
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomeBlockCount($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomeBlockSizes
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::getChromosomeBlockSizes
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetBlockSizesValid()
    {
        $value = array(16);
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomeBlockSizes($value);
        
        $this->assertEquals($value, $chromosome->getChromosomeBlockSizes());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomeBlockSizes
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetBlockSizesInvalid()
    {
        $value = array('fail');
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomeBlockSizes($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomePositionEnd
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::getChromosomePositionEnd
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetPositionEndValid()
    {
        $value = 16;
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomePositionEnd($value);
        
        $this->assertEquals($value, $chromosome->getChromosomePositionEnd());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomePositionEnd
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetPositionEndInvalid()
    {
        $value = 'fail';
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomePositionEnd($value);
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomePositionsStart
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::getChromosomePositionsStart
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetPositionsStartValid()
    {
        $value = array(
            12,
            16,
            20
        );
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomePositionsStart($value);
        
        $this->assertEquals($value, $chromosome->getChromosomePositionsStart());
    }

    /**
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::__construct
     * @covers pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry::setChromosomePositionsStart
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\ProteinEntry\ChromosomeProteinEntry
     */
    public function testCanGetSetPositionsStartInvalid1()
    {
        $value = array(
            1,
            'fail'
        );
        $chromosome = new ChromosomeProteinEntry(new Protein());
        $chromosome->setChromosomePositionsStart($value);
    }
}
