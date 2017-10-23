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

use pgb_liv\php_ms\Utility\Fragment\BFragment;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Utility\Fragment\YFragment;
use pgb_liv\php_ms\Utility\Fragment\CFragment;
use pgb_liv\php_ms\Utility\Fragment\ZFragment;
use pgb_liv\php_ms\Utility\Fragment\AFragment;
use pgb_liv\php_ms\Utility\Fragment\XFragment;

class FragmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse
     *       @group fragment
     */
    public function testObjectCanBeConstructedForValidConstructorArguments()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new BFragment($peptide);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $fragment);
        
        $fragment = new YFragment($peptide);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\YFragment', $fragment);
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     *
     * @expectedException InvalidArgumentException
     * @group fragment
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments()
    {
        $peptide = new Peptide();
        
        $fragment = new BFragment($peptide);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $fragment);
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\BFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsA()
    {
        $expected = array();
        $expected[1] = 70.06517;
        $expected[2] = 199.10776;
        $expected[3] = 296.16053;
        $expected[4] = 397.20821;
        $expected[5] = 510.29227;
        $expected[6] = 625.31921;
        $expected[7] = 754.36180;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new AFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertFalse($fragment->isReversed());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\BFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\BFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsB()
    {
        $expected = array();
        $expected[1] = 98.06009;
        $expected[2] = 227.10268;
        $expected[3] = 324.15544;
        $expected[4] = 425.20312;
        $expected[5] = 538.28718;
        $expected[6] = 653.31413;
        $expected[7] = 782.35672;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new BFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertFalse($fragment->isReversed());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\CFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\CFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\CFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsC()
    {
        $expected = array();
        $expected[1] = 115.08663;
        $expected[2] = 244.12923;
        $expected[3] = 341.18199;
        $expected[4] = 442.22967;
        $expected[5] = 555.31373;
        $expected[6] = 670.34068;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new CFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertFalse($fragment->isReversed());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::setIsReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\XFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\XFragment::getAdditiveMass
     * @covers pgb_liv\php_ms\Utility\Fragment\XFragment::getStart
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse
     * @uses pgb_liv\php_ms\Utility\Fragment\YFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsY()
    {
        $expected = array();
        $expected[2] = 729.29378;
        $expected[3] = 600.25119;
        $expected[4] = 503.19843;
        $expected[5] = 402.15075;
        $expected[6] = 289.06669;
        $expected[7] = 174.03974;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new XFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::setIsReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\YFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\YFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse
     * @uses pgb_liv\php_ms\Utility\Fragment\YFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsY()
    {
        $expected = array();
        $expected[1] = 148.06048;
        $expected[2] = 263.08742;
        $expected[3] = 376.17149;
        $expected[4] = 477.21916;
        $expected[5] = 574.27193;
        $expected[6] = 703.31452;
        $expected[7] = 800.36728;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new YFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }

    /**
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::setIsReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\ZFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\ZFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse
     * @uses pgb_liv\php_ms\Utility\Fragment\ZFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsZ()
    {
        $expected = array();
        $expected[1] = 131.03503;
        $expected[2] = 246.06197;
        $expected[3] = 359.14603;
        $expected[4] = 460.19371;
        $expected[5] = 557.24648;
        $expected[6] = 686.28907;
        $expected[7] = 783.34183;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new ZFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }
}
