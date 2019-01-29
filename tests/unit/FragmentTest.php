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

use pgb_liv\php_ms\Utility\Fragment\BFragment;
use pgb_liv\php_ms\Core\Peptide;
use pgb_liv\php_ms\Utility\Fragment\YFragment;
use pgb_liv\php_ms\Utility\Fragment\CFragment;
use pgb_liv\php_ms\Utility\Fragment\ZFragment;
use pgb_liv\php_ms\Utility\Fragment\AFragment;
use pgb_liv\php_ms\Utility\Fragment\XFragment;
use pgb_liv\php_ms\Core\Modification;
use pgb_liv\php_ms\Utility\Fragment\FragmentFactory;

class FragmentTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
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
     *
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
     *
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
        $expected[1] = 70.0651258;
        $expected[2] = 199.107718;
        $expected[3] = 296.160482;
        $expected[4] = 397.208161;
        $expected[5] = 510.292225;
        $expected[6] = 625.319168;
        $expected[7] = 754.361761;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new AFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertFalse($fragment->isReversed());
    }

    /**
     *
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
        
        $this->assertEquals(count($expected), count($ions));
        foreach ($ions as $key => $value) {
            $this->assertEquals($expected[$key], $value, null, 0.000015);
        }
        
        $this->assertFalse($fragment->isReversed());
    }

    /**
     *
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
        $expected[1] = 115.08658;
        $expected[2] = 244.12918;
        $expected[3] = 341.18194;
        $expected[4] = 442.22962;
        $expected[5] = 555.31368;
        $expected[6] = 670.34063;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new CFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertFalse($fragment->isReversed());
    }

    /**
     *
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
     * @uses pgb_liv\php_ms\Utility\Fragment\XFragment
     *       @group fragment
     */
    public function testObjectCanGetIonsX()
    {
        $expected = array();
        $expected[6] = 729.29374;
        $expected[5] = 600.25114;
        $expected[4] = 503.19838;
        $expected[3] = 402.15070;
        $expected[2] = 289.06664;
        $expected[1] = 174.03969;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new XFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }

    /**
     *
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
        $expected[7] = 800.36724;
        $expected[6] = 703.31447;
        $expected[5] = 574.27188;
        $expected[4] = 477.21912;
        $expected[3] = 376.17144;
        $expected[2] = 263.08737;
        $expected[1] = 148.06043;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new YFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }

    /**
     *
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
        $expected[7] = 783.34069;
        $expected[6] = 686.28792;
        $expected[5] = 557.24533;
        $expected[4] = 460.19257;
        $expected[3] = 359.14489;
        $expected[2] = 246.06082;
        $expected[1] = 131.03388;
        
        $peptide = new Peptide('PEPTIDE');
        
        $fragment = new ZFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
        $this->assertTrue($fragment->isReversed());
    }

    /**
     *
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
    public function testObjectCanGetModifiedIonsB()
    {
        $expected = array();
        $expected[1] = 114.96004;
        $expected[2] = 323.97268;
        $expected[3] = 421.02544;
        $expected[4] = 522.07312;
        $expected[5] = 635.15718;
        $expected[6] = 750.18413;
        $expected[7] = 1004.29672;
        
        $peptide = new Peptide('PEPTIDE');
        $nterm = new Modification();
        $nterm->setLocation(0);
        $nterm->setMonoisotopicMass(16.9);
        $peptide->addModification($nterm);
        
        $cterm = new Modification();
        $cterm->setLocation($peptide->getLength() + 1);
        $cterm->setMonoisotopicMass(45.1);
        $peptide->addModification($cterm);
        
        $phospho = new Modification();
        $phospho->setResidues(array(
            'E'
        ));
        $phospho->setMonoisotopicMass(79.97);
        $peptide->addModification($phospho);
        
        $fragment = new BFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragmentReverse::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::__construct
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getIons
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getNTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getCTerminalMass
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getStart
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::getEnd
     * @covers pgb_liv\php_ms\Utility\Fragment\AbstractFragment::isReversed
     * @covers pgb_liv\php_ms\Utility\Fragment\YFragment::getAdditiveMass
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\AbstractFragment
     * @uses pgb_liv\php_ms\Utility\Fragment\YFragment
     *       @group fragment
     */
    public function testObjectCanGetModifiedIonsY()
    {
        $expected = array();
        $expected[7] = 1022.3072;
        $expected[6] = 908.35447;
        $expected[5] = 699.34188;
        $expected[4] = 602.28912;
        $expected[3] = 501.24144;
        $expected[2] = 388.15737;
        $expected[1] = 273.13043;
        
        $peptide = new Peptide('PEPTIDE');
        $nterm = new Modification();
        $nterm->setLocation(0);
        $nterm->setMonoisotopicMass(16.9);
        $peptide->addModification($nterm);
        
        $cterm = new Modification();
        $cterm->setLocation($peptide->getLength() + 1);
        $cterm->setMonoisotopicMass(45.1);
        $peptide->addModification($cterm);
        
        $phospho = new Modification();
        $phospho->setResidues(array(
            'E'
        ));
        $phospho->setMonoisotopicMass(79.97);
        $peptide->addModification($phospho);
        
        $fragment = new YFragment($peptide);
        
        $ions = $fragment->getIons();
        
        $this->assertEquals($expected, $ions, null, 0.00001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getFragmentMethods
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetFragmentMethods()
    {
        $methods = FragmentFactory::getFragmentMethods();
        
        \PHPUnit_Framework_TestCase::assertAttributeEquals($methods, 'methods',
            'pgb_liv\php_ms\Utility\Fragment\FragmentFactory');
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodCID()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('CID', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $types['B']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\YFragment', $types['Y']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodHCD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('HCD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $types['B']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\YFragment', $types['Y']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodECD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('ECD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\CFragment', $types['C']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\ZFragment', $types['Z']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $types['B']);
        $this->assertEquals(3, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodETD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('ETD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\CFragment', $types['C']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\ZFragment', $types['Z']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodCTD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('CTD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\AFragment', $types['A']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\XFragment', $types['X']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodEDD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('EDD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\AFragment', $types['A']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\XFragment', $types['X']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodNETD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('NETD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\AFragment', $types['A']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\XFragment', $types['X']);
        $this->assertEquals(2, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodEThcD()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('EThcD', $peptide);
        
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\BFragment', $types['B']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\YFragment', $types['Y']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\CFragment', $types['C']);
        $this->assertInstanceOf('\pgb_liv\php_ms\Utility\Fragment\ZFragment', $types['Z']);
        $this->assertEquals(4, count($types));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Utility\Fragment\FragmentFactory::getMethodFragments
     *
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Utility\Fragment\FragmentFactory
     *       @group fragment
     */
    public function testObjectCanGetMethodUnknown()
    {
        $peptide = new Peptide('PEPTIDE');
        
        $types = FragmentFactory::getMethodFragments('MyUnknownMethod', $peptide);
    }
}
