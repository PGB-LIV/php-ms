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

use pgb_liv\php_ms\Search\Parameters\MascotSearchParameters;

class MascotSearchParametersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getIntermediate
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setIntermediate
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidIntermediate()
    {
        $value = 'Test';
        
        $params = new MascotSearchParameters();
        $params->setIntermediate($value);
        
        $this->assertEquals($value, $params->getIntermediate());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFormVersion
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFormVersion
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFormVersion()
    {
        $value = '1.2';
        
        $params = new MascotSearchParameters();
        $params->setFormVersion($value);
        
        $this->assertEquals($value, $params->getFormVersion());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getSearchType
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setSearchType
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidSearchType()
    {
        $value = 'SQ';
        
        $params = new MascotSearchParameters();
        $params->setSearchType($value);
        
        $this->assertEquals($value, $params->getSearchType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setSearchType
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanSetInvalidSearchType()
    {
        $value = 'fail';
        
        $params = new MascotSearchParameters();
        $params->setSearchType($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getRepType
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setRepType
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidRepType()
    {
        $value = 'concise';
        
        $params = new MascotSearchParameters();
        $params->setRepType($value);
        
        $this->assertEquals($value, $params->getRepType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getErrorTolerantRepeat
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setErrorTolerantRepeat
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidErrorTolerantRepeat()
    {
        $value = '1';
        
        $params = new MascotSearchParameters();
        $params->setErrorTolerantRepeat($value);
        
        $this->assertEquals($value, $params->getErrorTolerantRepeat());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getPeak
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setPeak
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidPeak()
    {
        $value = 'test';
        
        $params = new MascotSearchParameters();
        $params->setPeak($value);
        
        $this->assertEquals($value, $params->getPeak());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::isShowAllModsEnabled
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setShowAllModsEnabled
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidShowAllModsEnabled()
    {
        $value = 'test';
        
        $params = new MascotSearchParameters();
        $params->setShowAllModsEnabled($value);
        
        $this->assertEquals($value, $params->isShowAllModsEnabled());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setUserName
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getUserName
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidUserName()
    {
        $value = 'fred';
        
        $params = new MascotSearchParameters();
        $params->setUserName($value);
        
        $this->assertEquals($value, $params->getUserName());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setUserMail
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getUserMail
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidUserMail()
    {
        $value = 'example@example.com';
        
        $params = new MascotSearchParameters();
        $params->setUserMail($value);
        
        $this->assertEquals($value, $params->getUserMail());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setTitle
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getTitle
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidTitle()
    {
        $value = 'My Mascot Search';
        
        $params = new MascotSearchParameters();
        $params->setTitle($value);
        
        $this->assertEquals($value, $params->getTitle());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setDatabases
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidDatabases1()
    {
        $value = 'SwissProt';
        
        $params = new MascotSearchParameters();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setDatabases
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidDatabases2()
    {
        // TODO: Multi-DB test
        $value = 'SwissProt';
        
        $params = new MascotSearchParameters();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setEnzyme
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getEnzyme
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidEnzyme()
    {
        $value = 'Trypsin/P';
        
        $params = new MascotSearchParameters();
        $params->setEnzyme($value);
        
        $this->assertEquals($value, $params->getEnzyme());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMissedCleavageCount
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getMissedCleavageCount
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidMissedCleavageCount()
    {
        $value = 2;
        
        $params = new MascotSearchParameters();
        $params->setMissedCleavageCount($value);
        
        $this->assertEquals($value, $params->getMissedCleavageCount());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanSetInvalidMissedCleavageCountHigh()
    {
        $value = 10;
        
        $params = new MascotSearchParameters();
        $params->setMissedCleavageCount($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanSetInvalidMissedCleavageCountNegative()
    {
        $value = - 1;
        
        $params = new MascotSearchParameters();
        $params->setMissedCleavageCount($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMissedCleavageCount
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanSetInvalidMissedCleavageCountString()
    {
        $value = 'fail';
        
        $params = new MascotSearchParameters();
        $params->setMissedCleavageCount($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setQuantitation
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getQuantitation
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidQuantitation()
    {
        $value = 'SILAC K+6 R+10 [MD]';
        
        $params = new MascotSearchParameters();
        $params->setQuantitation($value);
        
        $this->assertEquals($value, $params->getQuantitation());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setTaxonomy
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getTaxonomy
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidTaxonomy()
    {
        $value = '. . Viruses';
        
        $params = new MascotSearchParameters();
        $params->setTaxonomy($value);
        
        $this->assertEquals($value, $params->getTaxonomy());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFixedModifications
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFixedModifications
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFixedModifications1()
    {
        $value = 'Carbamidomethyl (C)';
        
        $params = new MascotSearchParameters();
        $params->setFixedModifications($value);
        
        $this->assertEquals($value, $params->getFixedModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFixedModifications
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFixedModifications
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFixedModifications2()
    {
        // TODO: Support multiple mods
        $value = 'Carbamidomethyl (C)';
        
        $params = new MascotSearchParameters();
        $params->setFixedModifications($value);
        
        $this->assertEquals($value, $params->getFixedModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setVariableModifications
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getVariableModifications
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidVariableModifications1()
    {
        $value = 'Oxidation (M)';
        
        $params = new MascotSearchParameters();
        $params->setVariableModifications($value);
        
        $this->assertEquals($value, $params->getVariableModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setVariableModifications
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getVariableModifications
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidVariableModifications2()
    {
        // TODO: Support multiple mods
        $value = 'Oxidation (M)';
        
        $params = new MascotSearchParameters();
        $params->setVariableModifications($value);
        
        $this->assertEquals($value, $params->getVariableModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setPrecursorTolerance
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getPrecursorTolerance
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidPeptideTolerance()
    {
        $value = 10;
        
        $params = new MascotSearchParameters();
        $params->setPrecursorTolerance($value);
        
        $this->assertEquals($value, $params->getPrecursorTolerance());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setPrecursorToleranceUnit
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getPrecursorToleranceUnit
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidPeptideToleranceUnit()
    {
        $value = 'ppm';
        
        $params = new MascotSearchParameters();
        $params->setPrecursorToleranceUnit($value);
        
        $this->assertEquals($value, $params->getPrecursorToleranceUnit());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setPeptideIsotopeError
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getPeptideIsotopeError
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidPeptideIsotopeError()
    {
        $value = 1;
        
        $params = new MascotSearchParameters();
        $params->setPeptideIsotopeError($value);
        
        $this->assertEquals($value, $params->getPeptideIsotopeError());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFragmentTolerance
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFragmentTolerance
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFragmentTolerance()
    {
        $value = 0.1;
        
        $params = new MascotSearchParameters();
        $params->setFragmentTolerance($value);
        
        $this->assertEquals($value, $params->getFragmentTolerance());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFragmentToleranceUnit
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFragmentToleranceUnit
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFragmentToleranceUnit()
    {
        $value = 'Da';
        
        $params = new MascotSearchParameters();
        $params->setFragmentToleranceUnit($value);
        
        $this->assertEquals($value, $params->getFragmentToleranceUnit());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setCharge
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getCharge
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidCharge()
    {
        $value = '2+ and 3+';
        
        $params = new MascotSearchParameters();
        $params->setCharge($value);
        
        $this->assertEquals($value, $params->getCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setSpectraPath
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getSpectraPath
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidSpectraPath()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        touch($value);
        
        $params = new MascotSearchParameters();
        $params->setSpectraPath($value);
        
        $this->assertEquals($value, $params->getSpectraPath());
        unlink($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setFileFormat
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getFileFormat
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidFileFormat()
    {
        $value = 'mzML (.mzML)';
        
        $params = new MascotSearchParameters();
        $params->setFileFormat($value);
        
        $this->assertEquals($value, $params->getFileFormat());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getPrecursor
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setPrecursor
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidPrecursor()
    {
        $value = 125.4;
        
        $params = new MascotSearchParameters();
        $params->setPrecursor($value);
        
        $this->assertEquals($value, $params->getPrecursor());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getInstrument
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setInstrument
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidInstrument()
    {
        $value = 'CID+ETD';
        
        $params = new MascotSearchParameters();
        $params->setInstrument($value);
        
        $this->assertEquals($value, $params->getInstrument());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::isDecoyEnabled
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setDecoyEnabled
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidDecoyEnabled()
    {
        $value = true;
        
        $params = new MascotSearchParameters();
        $params->setDecoyEnabled($value);
        
        $this->assertEquals($value, $params->isDecoyEnabled());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getReport
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setReport
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidReport()
    {
        $value = 10;
        
        $params = new MascotSearchParameters();
        $params->setReport($value);
        
        $this->assertEquals($value, $params->getReport());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::getMassType
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMassType
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanGetSetValidMassType()
    {
        $value = MascotSearchParameters::MASS_AVG;
        
        $params = new MascotSearchParameters();
        $params->setMassType($value);
        
        $this->assertEquals($value, $params->getMassType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MascotSearchParameters::setMassType
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MascotSearchParameters
     */
    public function testCanSetInvalidMassType()
    {
        $value = 'fail';
        
        $params = new MascotSearchParameters();
        $params->setMassType($value);
    }
}
