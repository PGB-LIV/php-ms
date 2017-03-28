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
namespace pgb_liv\crowdsource\Test\Unit;

use pgb_liv\crowdsource\Core\Tolerance;

class ToleranceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\crowdsource\Core\Tolerance::__construct
     *
     * @uses pgb_liv\crowdsource\Core\Tolerance
     */
    public function testObjectCanBeConstructedForValidConstructorArguments1()
    {
        $tolerance = new Tolerance(7.5, 'ppm');
        $this->assertInstanceOf('pgb_liv\crowdsource\Core\Tolerance', $tolerance);
        
        return $tolerance;
    }

    /**
     * @covers pgb_liv\crowdsource\Core\Tolerance::__construct
     *
     * @uses pgb_liv\crowdsource\Core\Tolerance
     */
    public function testObjectCanBeConstructedForValidConstructorArguments2()
    {
        $tolerance = new Tolerance(0.5, 'da');
        $this->assertInstanceOf('pgb_liv\crowdsource\Core\Tolerance', $tolerance);
        
        return $tolerance;
    }

    /**
     * @covers pgb_liv\crowdsource\Core\Tolerance::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\crowdsource\Core\Tolerance
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        $tolerance = new Tolerance('fail', 'ppm');
        $this->assertInstanceOf('pgb_liv\crowdsource\Core\Tolerance', $tolerance);
    }

    /**
     * @covers pgb_liv\crowdsource\Core\Tolerance::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\crowdsource\Core\Tolerance
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        $tolerance = new Tolerance(0.6, 'dalton');
        $this->assertInstanceOf('pgb_liv\crowdsource\Core\Tolerance', $tolerance);
    }

    /**
     * @covers pgb_liv\crowdsource\Core\Tolerance::__construct
     * @covers pgb_liv\crowdsource\Core\Tolerance::getTolerance
     * @covers pgb_liv\crowdsource\Core\Tolerance::getUnit
     *
     * @uses pgb_liv\crowdsource\Core\Tolerance
     */
    public function testObjectCanGetConstructorArgs()
    {
        $value = 15.6;
        $unit = 'ppm';
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\crowdsource\Core\Tolerance', $tolerance);
        
        $this->assertEquals($value, $tolerance->getTolerance());
        $this->assertEquals($unit, $tolerance->getUnit());
    }
}
