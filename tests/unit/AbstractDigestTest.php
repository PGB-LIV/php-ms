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

use pgb_liv\php_ms\Utility\Digest\AbstractDigest;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Core\Protein;

class AbstractDigestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setNmeEnabled
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::getNmeEnabled
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiateGetSetValidNmeEnabled()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $stub->setNmeEnabled(true);
        $this->assertTrue($stub->isNmeEnabled());
        
        $stub->setNmeEnabled(false);
        $this->assertFalse($stub->isNmeEnabled());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setNmeEnabled
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiateSetInvalidNmeEnabled()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $stub->setNmeEnabled('fail');
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setMaxMissedCleavage
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::getMaxMissedCleavage
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiateGetSetValidMaxMissedCleavage()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $stub->setMaxMissedCleavage(15);
        $this->assertEquals(15, $stub->getMaxMissedCleavage());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setMaxMissedCleavage
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiateSetInvalidMaxMissedCleavage()
    {
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $stub->setMaxMissedCleavage('fail');
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::digest
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setNmeEnabled
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiatePeptideNmeEnabled()
    {
        $protein = new Protein();
        $protein->setSequence('MPEPTIDER');
        
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $peptide = new Peptide('MPEPTIDER');
        $peptide->setProtein($protein);
        $peptide->setPositionStart(0);
        $peptide->setPositionEnd(strlen('MPEPTIDER') - 1);
        $peptide->setMissedCleavageCount(0);
        
        $stub->expects($this->any())
            ->method('performDigestion')
            ->will($this->returnValue(array(
            $peptide
        )));
        
        $stub->setNmeEnabled(true);
        $peptides = $stub->digest($protein);
        
        $this->assertEquals('MPEPTIDER', $peptides[0]->getSequence());
        $this->assertEquals('PEPTIDER', $peptides[1]->getSequence());
        
        $this->assertEquals(2, count($peptides));
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::digest
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::setNmeEnabled
     * @covers pgb_liv\php_ms\Utility\Digest\AbstractDigest::performMethionineExcision
     *
     * @uses pgb_liv\php_ms\Utility\Digest\AbstractDigest
     */
    public function testCanValidiatePeptideNmeDisabled()
    {
        $protein = new Protein();
        $protein->setSequence('MPEPTIDER');
        
        $stub = $this->getMockForAbstractClass('pgb_liv\php_ms\Utility\Digest\AbstractDigest');
        
        $peptide = new Peptide('MPEPTIDER');
        $peptide->setProtein($protein);
        $peptide->setPositionStart(0);
        $peptide->setPositionEnd(strlen('MPEPTIDER') - 1);
        $peptide->setMissedCleavageCount(0);
        
        $stub->expects($this->any())
            ->method('performDigestion')
            ->will($this->returnValue(array(
            $peptide
        )));
        
        $stub->setNmeEnabled(true);
        $stub->setNmeEnabled(false);
        $peptides = $stub->digest($protein);
        
        $this->assertEquals('MPEPTIDER', $peptides[0]->getSequence());
        
        $this->assertEquals(1, count($peptides));
    }
}
