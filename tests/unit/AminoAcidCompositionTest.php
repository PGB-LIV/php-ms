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

use pgb_liv\php_ms\Core\AminoAcidComposition;
use pgb_liv\php_ms\Core\AminoAcidComposition;

class AminoAcidCompositionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormula
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryValid()
    {
        $this->assertEquals(AminoAcidComposition::A, AminoAcidComposition::getFormula('A'));
        $this->assertEquals(AminoAcidComposition::C, AminoAcidComposition::getFormula('C'));
        $this->assertEquals(AminoAcidComposition::D, AminoAcidComposition::getFormula('D'));
        $this->assertEquals(AminoAcidComposition::E, AminoAcidComposition::getFormula('E'));
        $this->assertEquals(AminoAcidComposition::F, AminoAcidComposition::getFormula('F'));
        $this->assertEquals(AminoAcidComposition::G, AminoAcidComposition::getFormula('G'));
        $this->assertEquals(AminoAcidComposition::H, AminoAcidComposition::getFormula('H'));
        $this->assertEquals(AminoAcidComposition::I, AminoAcidComposition::getFormula('I'));
        $this->assertEquals(AminoAcidComposition::K, AminoAcidComposition::getFormula('K'));
        $this->assertEquals(AminoAcidComposition::L, AminoAcidComposition::getFormula('L'));
        $this->assertEquals(AminoAcidComposition::M, AminoAcidComposition::getFormula('M'));
        $this->assertEquals(AminoAcidComposition::N, AminoAcidComposition::getFormula('N'));
        $this->assertEquals(AminoAcidComposition::P, AminoAcidComposition::getFormula('P'));
        $this->assertEquals(AminoAcidComposition::Q, AminoAcidComposition::getFormula('Q'));
        $this->assertEquals(AminoAcidComposition::R, AminoAcidComposition::getFormula('R'));
        $this->assertEquals(AminoAcidComposition::S, AminoAcidComposition::getFormula('S'));
        $this->assertEquals(AminoAcidComposition::T, AminoAcidComposition::getFormula('T'));
        $this->assertEquals(AminoAcidComposition::U, AminoAcidComposition::getFormula('U'));
        $this->assertEquals(AminoAcidComposition::V, AminoAcidComposition::getFormula('V'));
        $this->assertEquals(AminoAcidComposition::W, AminoAcidComposition::getFormula('W'));
        $this->assertEquals(AminoAcidComposition::Y, AminoAcidComposition::getFormula('Y'));
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormula
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryInvalidChar()
    {
        AminoAcidComposition::getFormula('X');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormula
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryInvalidString()
    {
        AminoAcidComposition::getFormula('PEPTIDE');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormulaInsensitive
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryValidInsensitive()
    {
        $this->assertEquals(AminoAcidComposition::A, AminoAcidComposition::getFormulaInsensitive('a'));
        $this->assertEquals(AminoAcidComposition::C, AminoAcidComposition::getFormulaInsensitive('c'));
        $this->assertEquals(AminoAcidComposition::D, AminoAcidComposition::getFormulaInsensitive('d'));
        $this->assertEquals(AminoAcidComposition::E, AminoAcidComposition::getFormulaInsensitive('e'));
        $this->assertEquals(AminoAcidComposition::F, AminoAcidComposition::getFormulaInsensitive('f'));
        $this->assertEquals(AminoAcidComposition::G, AminoAcidComposition::getFormulaInsensitive('g'));
        $this->assertEquals(AminoAcidComposition::H, AminoAcidComposition::getFormulaInsensitive('h'));
        $this->assertEquals(AminoAcidComposition::I, AminoAcidComposition::getFormulaInsensitive('i'));
        $this->assertEquals(AminoAcidComposition::K, AminoAcidComposition::getFormulaInsensitive('k'));
        $this->assertEquals(AminoAcidComposition::L, AminoAcidComposition::getFormulaInsensitive('l'));
        $this->assertEquals(AminoAcidComposition::M, AminoAcidComposition::getFormulaInsensitive('m'));
        $this->assertEquals(AminoAcidComposition::N, AminoAcidComposition::getFormulaInsensitive('n'));
        $this->assertEquals(AminoAcidComposition::P, AminoAcidComposition::getFormulaInsensitive('p'));
        $this->assertEquals(AminoAcidComposition::Q, AminoAcidComposition::getFormulaInsensitive('q'));
        $this->assertEquals(AminoAcidComposition::R, AminoAcidComposition::getFormulaInsensitive('r'));
        $this->assertEquals(AminoAcidComposition::S, AminoAcidComposition::getFormulaInsensitive('s'));
        $this->assertEquals(AminoAcidComposition::T, AminoAcidComposition::getFormulaInsensitive('t'));
        $this->assertEquals(AminoAcidComposition::U, AminoAcidComposition::getFormulaInsensitive('u'));
        $this->assertEquals(AminoAcidComposition::V, AminoAcidComposition::getFormulaInsensitive('v'));
        $this->assertEquals(AminoAcidComposition::W, AminoAcidComposition::getFormulaInsensitive('w'));
        $this->assertEquals(AminoAcidComposition::Y, AminoAcidComposition::getFormulaInsensitive('y'));
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormulaInsensitive
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryInvalidCharInsensitive()
    {
        AminoAcidComposition::getFormulaInsensitive('x');
    }

    /**
     * @covers pgb_liv\php_ms\Core\AminoAcidComposition::getFormulaInsensitive
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\AminoAcidComposition
     */
    public function testCanRetrieveEntryInvalidStringInsensitive()
    {
        AminoAcidComposition::getFormulaInsensitive('peptide');
    }
}
