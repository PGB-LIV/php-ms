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

use pgb_liv\php_ms\Core\Tolerance;

class ToleranceTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testObjectCanBeConstructedForValidConstructorArguments1()
    {
        $tolerance = new Tolerance(7.5, 'ppm');
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        return $tolerance;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testObjectCanBeConstructedForValidConstructorArguments2()
    {
        $tolerance = new Tolerance(0.5, Tolerance::DA);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        return $tolerance;
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments1()
    {
        $tolerance = new Tolerance('fail', Tolerance::PPM);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments2()
    {
        $tolerance = new Tolerance(0.6, 'dalton');
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::getTolerance
     * @covers pgb_liv\php_ms\Core\Tolerance::getUnit
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testObjectCanGetConstructorArgs()
    {
        $value = 15.6;
        $unit = 'ppm';
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertEquals($value, $tolerance->getTolerance());
        $this->assertEquals($unit, $tolerance->getUnit());
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::getDaltonDelta
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testCanGetDaltonDeltaPpm()
    {
        $value = 10;
        $unit = Tolerance::PPM;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertEquals(0.01, $tolerance->getDaltonDelta(1000), '', 0.001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::getDaltonDelta
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testCanGetDaltonDeltaDa()
    {
        $value = 0.5;
        $unit = Tolerance::DA;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertEquals($value, $tolerance->getDaltonDelta(1000));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::getPpmDelta
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testCanGetPpmDeltaPpm()
    {
        $value = 10;
        $unit = Tolerance::PPM;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertEquals($value, $tolerance->getPpmDelta(1000));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::getPpmDelta
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testCanGetPpmDeltaDa()
    {
        $value = 0.5;
        $unit = Tolerance::DA;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertEquals(500, $tolerance->getPpmDelta(1000), '', 0.001);
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::isTolerable
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifference
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifferencePpm
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testIsTolerablePpm()
    {
        $value = 5;
        $unit = Tolerance::PPM;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertTrue($tolerance->isTolerable(100, 100));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::isTolerable
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifference
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifferencePpm
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testIsNotTolerablePpm()
    {
        $value = 5;
        $unit = Tolerance::PPM;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertFalse($tolerance->isTolerable(100, 1000));
    }

    /**
     *
     * @covers pgb_liv\php_ms\Core\Tolerance::__construct
     * @covers pgb_liv\php_ms\Core\Tolerance::isTolerable
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifference
     * @covers pgb_liv\php_ms\Core\Tolerance::getDifferencePpm
     *
     * @uses pgb_liv\php_ms\Core\Tolerance
     */
    public function testIsTolerableDa()
    {
        $value = .5;
        $unit = Tolerance::DA;
        $tolerance = new Tolerance($value, $unit);
        $this->assertInstanceOf('pgb_liv\php_ms\Core\Tolerance', $tolerance);

        $this->assertTrue($tolerance->isTolerable(100, 100.1));
    }
}
