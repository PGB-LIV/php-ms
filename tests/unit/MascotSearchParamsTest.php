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

use pgb_liv\php_ms\Search\MascotSearchParams;

class MascotSearchParamsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getIntermediate
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setIntermediate
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidIntermediate()
    {
        $value = 'Test';
        
        $params = new MascotSearchParams();
        $params->setIntermediate($value);
        
        $this->assertEquals($value, $params->getIntermediate());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFormVersion
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFormVersion
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFormVersion()
    {
        $value = '1.2';
        
        $params = new MascotSearchParams();
        $params->setFormVersion($value);
        
        $this->assertEquals($value, $params->getFormVersion());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getSearchType
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setSearchType
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidSearchType()
    {
        $value = 'SQ';
        
        $params = new MascotSearchParams();
        $params->setSearchType($value);
        
        $this->assertEquals($value, $params->getSearchType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setSearchType
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanSetInvalidSearchType()
    {
        $value = 'fail';
        
        $params = new MascotSearchParams();
        $params->setSearchType($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getRepType
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setRepType
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidRepType()
    {
        $value = 'concise';
        
        $params = new MascotSearchParams();
        $params->setRepType($value);
        
        $this->assertEquals($value, $params->getRepType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getErrorTolerantRepeat
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setErrorTolerantRepeat
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidErrorTolerantRepeat()
    {
        $value = '1';
        
        $params = new MascotSearchParams();
        $params->setErrorTolerantRepeat($value);
        
        $this->assertEquals($value, $params->getErrorTolerantRepeat());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getPeak
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setPeak
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidPeak()
    {
        $value = 'test';
        
        $params = new MascotSearchParams();
        $params->setPeak($value);
        
        $this->assertEquals($value, $params->getPeak());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::isShowAllModsEnabled
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setShowAllModsEnabled
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidShowAllModsEnabled()
    {
        $value = 'test';
        
        $params = new MascotSearchParams();
        $params->setShowAllModsEnabled($value);
        
        $this->assertEquals($value, $params->isShowAllModsEnabled());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setUserName
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getUserName
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidUserName()
    {
        $value = 'fred';
        
        $params = new MascotSearchParams();
        $params->setUserName($value);
        
        $this->assertEquals($value, $params->getUserName());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setUserMail
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getUserMail
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidUserMail()
    {
        $value = 'example@example.com';
        
        $params = new MascotSearchParams();
        $params->setUserMail($value);
        
        $this->assertEquals($value, $params->getUserMail());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setTitle
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getTitle
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidTitle()
    {
        $value = 'My Mascot Search';
        
        $params = new MascotSearchParams();
        $params->setTitle($value);
        
        $this->assertEquals($value, $params->getTitle());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setDatabases
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidDatabases1()
    {
        $value = 'SwissProt';
        
        $params = new MascotSearchParams();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setDatabases
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getDatabases
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidDatabases2()
    {
        // TODO: Multi-DB test
        $value = 'SwissProt';
        
        $params = new MascotSearchParams();
        $params->setDatabases($value);
        
        $this->assertEquals($value, $params->getDatabases());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setEnzyme
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getEnzyme
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidEnzyme()
    {
        $value = 'Trypsin/P';
        
        $params = new MascotSearchParams();
        $params->setEnzyme($value);
        
        $this->assertEquals($value, $params->getEnzyme());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setMissedCleavageCount
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getMissedCleavageCount
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidMissedCleavageCount()
    {
        $value = 2;
        
        $params = new MascotSearchParams();
        $params->setMissedCleavageCount($value);
        
        $this->assertEquals($value, $params->getMissedCleavageCount());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setQuantitation
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getQuantitation
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidQuantitation()
    {
        $value = 'SILAC K+6 R+10 [MD]';
        
        $params = new MascotSearchParams();
        $params->setQuantitation($value);
        
        $this->assertEquals($value, $params->getQuantitation());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setTaxonomy
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getTaxonomy
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidTaxonomy()
    {
        $value = '. . Viruses';
        
        $params = new MascotSearchParams();
        $params->setTaxonomy($value);
        
        $this->assertEquals($value, $params->getTaxonomy());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFixedModifications
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFixedModifications
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFixedModifications1()
    {
        $value = 'Carbamidomethyl (C)';
        
        $params = new MascotSearchParams();
        $params->setFixedModifications($value);
        
        $this->assertEquals($value, $params->getFixedModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFixedModifications
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFixedModifications
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFixedModifications2()
    {
        // TODO: Support multiple mods
        $value = 'Carbamidomethyl (C)';
        
        $params = new MascotSearchParams();
        $params->setFixedModifications($value);
        
        $this->assertEquals($value, $params->getFixedModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setVariableModifications
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getVariableModifications
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidVariableModifications1()
    {
        $value = 'Oxidation (M)';
        
        $params = new MascotSearchParams();
        $params->setVariableModifications($value);
        
        $this->assertEquals($value, $params->getVariableModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setVariableModifications
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getVariableModifications
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidVariableModifications2()
    {
        // TODO: Support multiple mods
        $value = 'Oxidation (M)';
        
        $params = new MascotSearchParams();
        $params->setVariableModifications($value);
        
        $this->assertEquals($value, $params->getVariableModifications());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setPrecursorTolerance
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getPrecursorTolerance
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidPeptideTolerance()
    {
        $value = 10;
        
        $params = new MascotSearchParams();
        $params->setPrecursorTolerance($value);
        
        $this->assertEquals($value, $params->getPrecursorTolerance());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setPrecursorToleranceUnit
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getPrecursorToleranceUnit
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidPeptideToleranceUnit()
    {
        $value = 'ppm';
        
        $params = new MascotSearchParams();
        $params->setPrecursorToleranceUnit($value);
        
        $this->assertEquals($value, $params->getPrecursorToleranceUnit());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setPeptideIsotopeError
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getPeptideIsotopeError
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidPeptideIsotopeError()
    {
        $value = 1;
        
        $params = new MascotSearchParams();
        $params->setPeptideIsotopeError($value);
        
        $this->assertEquals($value, $params->getPeptideIsotopeError());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFragmentTolerance
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFragmentTolerance
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFragmentTolerance()
    {
        $value = 0.1;
        
        $params = new MascotSearchParams();
        $params->setFragmentTolerance($value);
        
        $this->assertEquals($value, $params->getFragmentTolerance());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFragmentToleranceUnit
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFragmentToleranceUnit
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFragmentToleranceUnit()
    {
        $value = 'Da';
        
        $params = new MascotSearchParams();
        $params->setFragmentToleranceUnit($value);
        
        $this->assertEquals($value, $params->getFragmentToleranceUnit());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setCharge
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getCharge
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidCharge()
    {
        $value = '2+ and 3+';
        
        $params = new MascotSearchParams();
        $params->setCharge($value);
        
        $this->assertEquals($value, $params->getCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFilePath
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFilePath
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFilePath()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        touch($value);
        
        $params = new MascotSearchParams();
        $params->setFilePath($value);
        
        $this->assertEquals($value, $params->getFilePath());
        unlink($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setFileFormat
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getFileFormat
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidFileFormat()
    {
        $value = 'mzML (.mzML)';
        
        $params = new MascotSearchParams();
        $params->setFileFormat($value);
        
        $this->assertEquals($value, $params->getFileFormat());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getPrecursor
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setPrecursor
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidPrecursor()
    {
        $value = 125.4;
        
        $params = new MascotSearchParams();
        $params->setPrecursor($value);
        
        $this->assertEquals($value, $params->getPrecursor());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getInstrument
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setInstrument
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidInstrument()
    {
        $value = 'CID+ETD';
        
        $params = new MascotSearchParams();
        $params->setInstrument($value);
        
        $this->assertEquals($value, $params->getInstrument());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::isDecoyEnabled
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setDecoyEnabled
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidDecoyEnabled()
    {
        $value = true;
        
        $params = new MascotSearchParams();
        $params->setDecoyEnabled($value);
        
        $this->assertEquals($value, $params->isDecoyEnabled());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getReport
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setReport
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidReport()
    {
        $value = 10;
        
        $params = new MascotSearchParams();
        $params->setReport($value);
        
        $this->assertEquals($value, $params->getReport());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::getMassType
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setMassType
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanGetSetValidMassType()
    {
        $value = MascotSearchParams::MASS_AVG;
        
        $params = new MascotSearchParams();
        $params->setMassType($value);
        
        $this->assertEquals($value, $params->getMassType());
    }

    /**
     * @covers pgb_liv\php_ms\Search\MascotSearchParams::setMassType
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\MascotSearchParams
     */
    public function testCanSetInvalidMassType()
    {
        $value = 'fail';
        
        $params = new MascotSearchParams();
        $params->setMassType($value);
    }
}
