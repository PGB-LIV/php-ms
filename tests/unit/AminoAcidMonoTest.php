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

use pgb_liv\php_ms\Core\AminoAcidMono;

class AminoAcidMonoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicMass
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryValid()
    {
        $this->assertEquals(AminoAcidMono::A, AminoAcidMono::getMonoisotopicMass('A'));
        $this->assertEquals(AminoAcidMono::C, AminoAcidMono::getMonoisotopicMass('C'));
        $this->assertEquals(AminoAcidMono::D, AminoAcidMono::getMonoisotopicMass('D'));
        $this->assertEquals(AminoAcidMono::E, AminoAcidMono::getMonoisotopicMass('E'));
        $this->assertEquals(AminoAcidMono::F, AminoAcidMono::getMonoisotopicMass('F'));
        $this->assertEquals(AminoAcidMono::G, AminoAcidMono::getMonoisotopicMass('G'));
        $this->assertEquals(AminoAcidMono::H, AminoAcidMono::getMonoisotopicMass('H'));
        $this->assertEquals(AminoAcidMono::I, AminoAcidMono::getMonoisotopicMass('I'));
        $this->assertEquals(AminoAcidMono::K, AminoAcidMono::getMonoisotopicMass('K'));
        $this->assertEquals(AminoAcidMono::L, AminoAcidMono::getMonoisotopicMass('L'));
        $this->assertEquals(AminoAcidMono::M, AminoAcidMono::getMonoisotopicMass('M'));
        $this->assertEquals(AminoAcidMono::N, AminoAcidMono::getMonoisotopicMass('N'));
        $this->assertEquals(AminoAcidMono::P, AminoAcidMono::getMonoisotopicMass('P'));
        $this->assertEquals(AminoAcidMono::Q, AminoAcidMono::getMonoisotopicMass('Q'));
        $this->assertEquals(AminoAcidMono::R, AminoAcidMono::getMonoisotopicMass('R'));
        $this->assertEquals(AminoAcidMono::S, AminoAcidMono::getMonoisotopicMass('S'));
        $this->assertEquals(AminoAcidMono::T, AminoAcidMono::getMonoisotopicMass('T'));
        $this->assertEquals(AminoAcidMono::U, AminoAcidMono::getMonoisotopicMass('U'));
        $this->assertEquals(AminoAcidMono::V, AminoAcidMono::getMonoisotopicMass('V'));
        $this->assertEquals(AminoAcidMono::W, AminoAcidMono::getMonoisotopicMass('W'));
        $this->assertEquals(AminoAcidMono::Y, AminoAcidMono::getMonoisotopicMass('Y'));
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryInvalidChar()
    {
        AminoAcidMono::getMonoisotopicMass('X');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryInvalidString()
    {
        AminoAcidMono::getMonoisotopicMass('PEPTIDE');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicInsensitive
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryValidInsensitive()
    {
        $this->assertEquals(AminoAcidMono::A, AminoAcidMono::getMonoisotopicInsensitive('a'));
        $this->assertEquals(AminoAcidMono::C, AminoAcidMono::getMonoisotopicInsensitive('c'));
        $this->assertEquals(AminoAcidMono::D, AminoAcidMono::getMonoisotopicInsensitive('d'));
        $this->assertEquals(AminoAcidMono::E, AminoAcidMono::getMonoisotopicInsensitive('e'));
        $this->assertEquals(AminoAcidMono::F, AminoAcidMono::getMonoisotopicInsensitive('f'));
        $this->assertEquals(AminoAcidMono::G, AminoAcidMono::getMonoisotopicInsensitive('g'));
        $this->assertEquals(AminoAcidMono::H, AminoAcidMono::getMonoisotopicInsensitive('h'));
        $this->assertEquals(AminoAcidMono::I, AminoAcidMono::getMonoisotopicInsensitive('i'));
        $this->assertEquals(AminoAcidMono::K, AminoAcidMono::getMonoisotopicInsensitive('k'));
        $this->assertEquals(AminoAcidMono::L, AminoAcidMono::getMonoisotopicInsensitive('l'));
        $this->assertEquals(AminoAcidMono::M, AminoAcidMono::getMonoisotopicInsensitive('m'));
        $this->assertEquals(AminoAcidMono::N, AminoAcidMono::getMonoisotopicInsensitive('n'));
        $this->assertEquals(AminoAcidMono::P, AminoAcidMono::getMonoisotopicInsensitive('p'));
        $this->assertEquals(AminoAcidMono::Q, AminoAcidMono::getMonoisotopicInsensitive('q'));
        $this->assertEquals(AminoAcidMono::R, AminoAcidMono::getMonoisotopicInsensitive('r'));
        $this->assertEquals(AminoAcidMono::S, AminoAcidMono::getMonoisotopicInsensitive('s'));
        $this->assertEquals(AminoAcidMono::T, AminoAcidMono::getMonoisotopicInsensitive('t'));
        $this->assertEquals(AminoAcidMono::U, AminoAcidMono::getMonoisotopicInsensitive('u'));
        $this->assertEquals(AminoAcidMono::V, AminoAcidMono::getMonoisotopicInsensitive('v'));
        $this->assertEquals(AminoAcidMono::W, AminoAcidMono::getMonoisotopicInsensitive('w'));
        $this->assertEquals(AminoAcidMono::Y, AminoAcidMono::getMonoisotopicInsensitive('y'));
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicInsensitive
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryInvalidCharInsensitive()
    {
        AminoAcidMono::getMonoisotopicInsensitive('x');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidMono::getMonoisotopicInsensitive
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidMono
     */
    public function testCanRetrieveEntryInvalidStringInsensitive()
    {
        AminoAcidMono::getMonoisotopicInsensitive('peptide');
    }
}
