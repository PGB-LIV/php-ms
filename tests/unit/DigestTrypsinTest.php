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

use pgb_liv\php_ms\Utility\Digest\DigestTrypsin;
use pgb_liv\php_ms\Core\Protein;

class DigestTrypsinTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $trypsin = new DigestTrypsin();
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Digest\DigestTrypsin', $trypsin);
        
        return $trypsin;
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryK()
    {
        $peptideStrings = array();
        $peptideStrings[0] = 'EPTIDEK';
        $peptideStrings[1] = 'EPTIDE';
        $protein = new Protein();
        $protein->setSequence(implode('', $peptideStrings));
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $i = 0;
        foreach ($peptides as $peptide) {
            $this->assertEquals($peptideStrings[$i], $peptide->getSequence());
            $i ++;
        }
        
        $this->assertEquals(count($peptideStrings), count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryR()
    {
        $peptideStrings = array();
        $peptideStrings[0] = 'EPTIDER';
        $peptideStrings[1] = 'EPTIDE';
        $protein = new Protein();
        $protein->setSequence(implode('', $peptideStrings));
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $i = 0;
        foreach ($peptides as $peptide) {
            $this->assertEquals($peptideStrings[$i], $peptide->getSequence());
            $i ++;
        }
        
        $this->assertEquals(count($peptideStrings), count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryKR()
    {
        $peptideStrings = array();
        $peptideStrings[0] = 'EPTIDEK';
        $peptideStrings[1] = 'R';
        $peptideStrings[1] = 'EPTIDE';
        $protein = new Protein();
        $protein->setSequence(implode('', $peptideStrings));
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $i = 0;
        foreach ($peptides as $peptide) {
            $this->assertEquals($peptideStrings[$i], $peptide->getSequence());
            $i ++;
        }
        
        $this->assertEquals(count($peptideStrings), count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryKP()
    {
        $peptideStrings = array();
        $peptideStrings[0] = 'EPTIDEKPEPTIDE';
        $protein = new Protein();
        $protein->setSequence(implode('', $peptideStrings));
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $i = 0;
        foreach ($peptides as $peptide) {
            $this->assertEquals($peptideStrings[$i], $peptide->getSequence());
            $i ++;
        }
        
        $this->assertEquals(count($peptideStrings), count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryRP()
    {
        $peptideStrings = array();
        $peptideStrings[0] = 'EPTIDEKPEPTIDE';
        $protein = new Protein();
        $protein->setSequence(implode('', $peptideStrings));
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $i = 0;
        foreach ($peptides as $peptide) {
            $this->assertEquals($peptideStrings[$i], $peptide->getSequence());
            $i ++;
        }
        
        $this->assertEquals(count($peptideStrings), count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setMaxMissedCleavage
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateEntryMissCleave()
    {
        $protein = new Protein();
        $protein->setSequence('EPTIDEKEPTIDE');
        
        $trypsin = new DigestTrypsin();
        $trypsin->setMaxMissedCleavage(1);
        $peptides = $trypsin->digest($protein);
        
        $this->assertEquals('EPTIDEK', $peptides[0]->getSequence());
        $this->assertEquals('EPTIDE', $peptides[1]->getSequence());
        $this->assertEquals('EPTIDEKEPTIDE', $peptides[2]->getSequence());
        
        $this->assertEquals(3, count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::digest
     * @covers pgb_liv\php_ms\Utility\Digest\DigestRegularExpression::performDigestion
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestRegularExpression
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidateSiteAtEnd()
    {
        $protein = new Protein();
        $protein->setSequence('PEPTIDER');
        
        $trypsin = new DigestTrypsin();
        $peptides = $trypsin->digest($protein);
        
        $this->assertEquals('PEPTIDER', $peptides[0]->getSequence());
        
        $this->assertEquals(1, count($peptides));
    }
}
