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

use pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters;

class AbstractSearchParametersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setDatabases
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanValidiateGetSetValidNmeEnabled()
    {
        $value = 'SwissProt';
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setDatabases
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetValidDatabases2()
    {        
        // TODO: Multi-DB test
        $value = 'SwissProt';
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setEnzyme
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::getEnzyme
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetValidEnzyme()
    {
        $value = 'Trypsin/P';
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setEnzyme($value);
        
        $this->assertEquals($value, $params->getEnzyme());
    }
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setMissedCleavageCount
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::getMissedCleavageCount
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetValidMissedCleavageCount()
    {
        $value = 2;
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setMissedCleavageCount($value);
        
        $this->assertEquals($value, $params->getMissedCleavageCount());
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanSetInvalidMissedCleavageCountNegative()
    {
        $value = - 1;
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setMissedCleavageCount($value);
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanSetInvalidMissedCleavageCountString()
    {
        $value = 'fail';
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setMissedCleavageCount($value);
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setSpectraPath
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::getSpectraPath
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetValidSpectraPath()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        touch($value);
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setSpectraPath($value);
        
        $this->assertEquals($value, $params->getSpectraPath());
        unlink($value);
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setSpectraPath
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetInvalidSpectraPath()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        unlink($value);
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setSpectraPath($value);
        
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setDecoyEnabled
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::isDecoyEnabled
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetValidDecoyEnabled()
    {
        $value = true;
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setDecoyEnabled($value);
        
        $this->assertEquals($value, $params->isDecoyEnabled());
    }
    
    /**
     * @covers pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters::setDecoyEnabled
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters
     */
    public function testCanGetSetInvalidDecoyEnabled()
    {
        $value = 'string';
        
        $params = $this->getMockForAbstractClass('pgb_liv\php_ms\Search\Parameters\AbstractSearchParameters');
        $params->setDecoyEnabled($value);
        
        $this->assertEquals($value, $params->isDecoyEnabled());
    }
}
