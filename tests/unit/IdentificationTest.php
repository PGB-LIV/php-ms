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

use pgb_liv\php_ms\Core\Identification;
use pgb_liv\php_ms\Core\Peptide;

class IdentificationTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $identification = new Identification();
        $this->assertInstanceOf('\pgb_liv\php_ms\Core\Identification', $identification);

        return $identification;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setPeptide
     * @covers pgb_liv\php_ms\Core\Identification::getPeptide
     * @covers pgb_liv\php_ms\Core\Identification::setSequence
     * @covers pgb_liv\php_ms\Core\Identification::getSequence
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetPeptide()
    {
        $peptide = new Peptide("PEPTIDE");

        $identification = new Identification();
        $identification->setSequence($peptide);

        $this->assertEquals($peptide, $identification->getSequence());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setScore
     * @covers pgb_liv\php_ms\Core\Identification::getScore
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetScore()
    {
        $pValue = 124.1598;
        $eValue = 17.8961;
        $identification = new Identification();
        $identification->setScore('pValue', $pValue);
        $identification->setScore('eValue', $eValue);

        $this->assertEquals($pValue, $identification->getScore('pValue'));
        $this->assertEquals($eValue, $identification->getScore('eValue'));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setScore
     * @covers pgb_liv\php_ms\Core\Identification::getScore
     * @covers pgb_liv\php_ms\Core\Identification::getScores
     * @covers pgb_liv\php_ms\Core\Identification::clearScores
     * @expectedException OutOfBoundsException
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanClearScores()
    {
        $pValue = 124.1598;
        $eValue = 17.8961;
        $identification = new Identification();
        $identification->setScore('pValue', $pValue);
        $identification->setScore('eValue', $eValue);

        $identification->clearScores();

        $this->assertEquals(0, count($identification->getScores()));

        $identification->getScore('pValue');
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setIonsMatched
     * @covers pgb_liv\php_ms\Core\Identification::getIonsMatched
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetIonsMatchedValid()
    {
        $ionsMatched = 9;
        $identification = new Identification();
        $identification->setIonsMatched($ionsMatched);

        $this->assertEquals($ionsMatched, $identification->getIonsMatched());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setIonsMatched
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetIonsMatchedInvalid()
    {
        $ionsMatched = 'fail';
        $identification = new Identification();
        $identification->setIonsMatched($ionsMatched);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setRank
     * @covers pgb_liv\php_ms\Core\Identification::getRank
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetRankValid()
    {
        $rank = 1;
        $identification = new Identification();
        $identification->setRank($rank);

        $this->assertEquals($rank, $identification->getRank());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Identification::setRank
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Identification
     */
    public function testCanGetSetRankInvalid()
    {
        $rank = 'fail';
        $identification = new Identification();
        $identification->setRank($rank);
    }
}
