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

use pgb_liv\php_ms\Utility\Digest\DigestFactory;

class DigestFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFactory::getEnzymes
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFactory::getDigest
     * @covers pgb_liv\php_ms\Utility\Digest\Digest2Iodobenzoate::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestArgC::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestAspN::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestAspNAmbic::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestChymotrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestCnbr::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFormicAcid::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestGlutamylEndopeptidase::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestLeukocyteElastase::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestLysC::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestLysCP::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestPepsinA::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestProlineEndopeptidase::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypChymo::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsin::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestTrypsinP::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestV8DE::__construct
     * @covers pgb_liv\php_ms\Utility\Digest\DigestV8E::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFactory
     * @uses pgb_liv\php_ms\Utility\Digest\Digest2Iodobenzoate
     * @uses pgb_liv\php_ms\Utility\Digest\DigestArgC
     * @uses pgb_liv\php_ms\Utility\Digest\DigestAspN
     * @uses pgb_liv\php_ms\Utility\Digest\DigestAspNAmbic
     * @uses pgb_liv\php_ms\Utility\Digest\DigestChymotrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestCnbr
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFormicAcid
     * @uses pgb_liv\php_ms\Utility\Digest\DigestGlutamylEndopeptidase
     * @uses pgb_liv\php_ms\Utility\Digest\DigestLeukocyteElastase
     * @uses pgb_liv\php_ms\Utility\Digest\DigestLysC
     * @uses pgb_liv\php_ms\Utility\Digest\DigestLysCP
     * @uses pgb_liv\php_ms\Utility\Digest\DigestPepsinA
     * @uses pgb_liv\php_ms\Utility\Digest\DigestProlineEndopeptidase
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypChymo
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsin
     * @uses pgb_liv\php_ms\Utility\Digest\DigestTrypsinP
     * @uses pgb_liv\php_ms\Utility\Digest\DigestV8DE
     * @uses pgb_liv\php_ms\Utility\Digest\DigestV8E
     *       @group digest
     */
    public function testCanConstructByClassName()
    {
        $enzymes = DigestFactory::getEnzymes();
        
        foreach (array_keys($enzymes) as $key) {
            $enzyme = DigestFactory::getDigest($key);
            
            $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Digest\Digest' . $key, $enzyme);
        }
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFactory::getDigest
     *
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFactory
     *       @group digest
     */
    public function testCanConstructInvalid()
    {
        DigestFactory::getDigest('fail');
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFactory::getEnzymes
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFactory
     *       @group digest
     */
    public function testCanGetEnzymes()
    {
        $enzymes = DigestFactory::getEnzymes();
        
        $this->assertTrue(array_key_exists('2Iodobenzoate', $enzymes));
        $this->assertTrue(array_key_exists('ArgC', $enzymes));
        $this->assertTrue(array_key_exists('AspN', $enzymes));
        $this->assertTrue(array_key_exists('AspNAmbic', $enzymes));
        $this->assertTrue(array_key_exists('Chymotrypsin', $enzymes));
        $this->assertTrue(array_key_exists('Cnbr', $enzymes));
        $this->assertTrue(array_key_exists('FormicAcid', $enzymes));
        $this->assertTrue(array_key_exists('GlutamylEndopeptidase', $enzymes));
        $this->assertTrue(array_key_exists('LeukocyteElastase', $enzymes));
        $this->assertTrue(array_key_exists('LysC', $enzymes));
        $this->assertTrue(array_key_exists('LysCP', $enzymes));
        $this->assertTrue(array_key_exists('PepsinA', $enzymes));
        $this->assertTrue(array_key_exists('ProlineEndopeptidase', $enzymes));
        $this->assertTrue(array_key_exists('TrypChymo', $enzymes));
        $this->assertTrue(array_key_exists('Trypsin', $enzymes));
        $this->assertTrue(array_key_exists('TrypsinP', $enzymes));
        $this->assertTrue(array_key_exists('V8DE', $enzymes));
        $this->assertTrue(array_key_exists('V8E', $enzymes));
        $this->assertEquals(18, count($enzymes));
    }
}
