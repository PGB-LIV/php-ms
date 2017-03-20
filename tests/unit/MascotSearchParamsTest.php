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

use pgb_liv\php_ms\Search\MascotSearchParamsTest;

class MascotSearchParamsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setUserName
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::getUserName
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidUserName()
    {
        $value = 'fred';
        
        $params = new MascotSearchParamsTest();
        $params->setUserName($value);
        
        $this->assertEquals($value, $params->getUserName());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setUserMail
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setUserMail
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidUserMail()
    {
        $value = 'example@example.com';
        
        $params = new MascotSearchParamsTest();
        $params->setUserMail($value);
        
        $this->assertEquals($value, $params->getUserMail());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setUserMail
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setUserMail
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidTitle()
    {
        $value = 'example@example.com';
        
        $params = new MascotSearchParamsTest();
        $params->setTitle($value);
        
        $this->assertEquals($value, $params->getTitle());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setDatabases
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidDatabases1()
    {
        $value = 'SwissProt';
        
        $params = new MascotSearchParamsTest();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setDatabases
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidDatabases2()
    {
        // TODO: Multi-DB test
        $value = 'SwissProt';
        
        $params = new MascotSearchParamsTest();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::setEnzyme
     * @covers pgb_liv\php_ms\Search\MascotSearchParamsTest::getEnzyme
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParamsTest
     */
    public function testCanGetSetValidEnzyme()
    {
        $value = 'Trypsin/P';
        
        $params = new MascotSearchParamsTest();
        $params->setEnzyme($value);
        
        $this->assertEquals($value, $params->getEnzyme());
    }
}
