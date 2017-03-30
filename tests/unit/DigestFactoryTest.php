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
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFactory
     */
    public function testCanConstructByClassName()
    {
        $enzymes = DigestFactory::getEnzymes();
        
        foreach ($enzymes as $key => $value) {
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
     */
    public function testCanConstructInvalid()
    {
        $trypsin = DigestFactory::getDigest('fail');
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Digest\DigestFactory::getEnzymes
     *
     * @uses pgb_liv\php_ms\Utility\Digest\DigestFactory
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
