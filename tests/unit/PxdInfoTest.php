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

use pgb_liv\php_ms\Reader\PxdInfo;

class PxdInfoTest extends \PHPUnit_Framework_TestCase
{

    private $pxOffline = false;

    /**
     * @covers pgb_liv\php_ms\Reader\PxdInfo::__construct
     *
     * @uses pgb_liv\php_ms\Reader\PxdInfo
     *       @group online
     */
    public function testObjectCanBeConstructedForValidConstructorArgumentsInt()
    {
        if ($this->pxOffline) {
            $this->markTestSkipped('The ProteomeExchange offline.');
            return;
        }
        
        $id = 100;
        try {
            $info = new PxdInfo($id);
            $this->assertInstanceOf('pgb_liv\php_ms\Reader\PxdInfo', $info);
        } catch (\Exception $e) {
            $this->pxOffline = true;
            $this->markTestSkipped('The ProteomeExchange offline.');
        }
    }

    /**
     * @covers pgb_liv\php_ms\Reader\PxdInfo::__construct
     *
     * @uses pgb_liv\php_ms\Reader\PxdInfo
     *       @group online
     */
    public function testObjectCanBeConstructedForValidConstructorArgumentsString()
    {
        if ($this->pxOffline) {
            $this->markTestSkipped('The ProteomeExchange offline.');
            return;
        }
        
        $id = 'PXD000100';
        try {
            $info = new PxdInfo($id);
            $this->assertInstanceOf('pgb_liv\php_ms\Reader\PxdInfo', $info);
        } catch (\Exception $e) {
            $this->pxOffline = true;
            $this->markTestSkipped('The ProteomeExchange offline.');
        }
    }

    /**
     * @covers pgb_liv\php_ms\Reader\PxdInfo::__construct
     *
     * @uses pgb_liv\php_ms\Reader\PxdInfo
     *       @group online
     */
    public function testObjectCanBeConstructedForValidConstructorArgumentsStringInt()
    {
        if ($this->pxOffline) {
            $this->markTestSkipped('The ProteomeExchange offline.');
            return;
        }
        
        $id = '100';
        try {
            $info = new PxdInfo($id);
            $this->assertInstanceOf('pgb_liv\php_ms\Reader\PxdInfo', $info);
        } catch (\Exception $e) {
            $this->pxOffline = true;
            $this->markTestSkipped('The ProteomeExchange offline.');
        }
    }

    /**
     * @covers pgb_liv\php_ms\Reader\PxdInfo::__construct
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Reader\PxdInfo
     *       @group online
     */
    public function testObjectCanBeConstructedForInvalidConstructorArguments()
    {
        if ($this->pxOffline) {
            $this->markTestSkipped('The ProteomeExchange offline.');
            return;
        }
        
        $id = 'fail';
        try {
            $info = new PxdInfo($id);
            $this->assertInstanceOf('pgb_liv\php_ms\Reader\PxdInfo', $info);
        } catch (\Exception $e) {
            $this->pxOffline = true;
            $this->markTestSkipped('The ProteomeExchange offline.');
        }
    }
}
