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

use pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters;

class MsgfPlusSearchParametersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setChargeCarrierMass
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getChargeCarrierMass
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidChargeCarrierMass()
    {
        $value = 1.1;
        
        $params = new MsgfPlusSearchParameters();
        $params->setChargeCarrierMass($value);
        
        $this->assertEquals($value, $params->getChargeCarrierMass());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setChargeCarrierMass
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidChargeCarrierMass()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setChargeCarrierMass($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setEnzyme
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getEnzyme
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidEnzyme()
    {
        $value = 2;
        
        $params = new MsgfPlusSearchParameters();
        $params->setEnzyme($value);
        
        $this->assertEquals($value, $params->getEnzyme());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setEnzyme
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidEnzyme()
    {
        $value = 'Trypsin';
        
        $params = new MsgfPlusSearchParameters();
        $params->setEnzyme($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setFragmentationMethodId
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getFragmentationMethodId
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidFragmentationMethodId()
    {
        $value = 1;
        
        $params = new MsgfPlusSearchParameters();
        $params->setFragmentationMethodId($value);
        
        $this->assertEquals($value, $params->getFragmentationMethodId());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setFragmentationMethodId
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidFragmentationMethodId()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setFragmentationMethodId($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setIsotopeErrorRange
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getIsotopeErrorRange
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidIsotopeErrorRange()
    {
        $value = '-1,2';
        
        $params = new MsgfPlusSearchParameters();
        $params->setIsotopeErrorRange($value);
        
        $this->assertEquals($value, $params->getIsotopeErrorRange());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMaxPeptideLength
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getMaxPeptideLength
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidMaxPeptideLength()
    {
        $value = 65;
        
        $params = new MsgfPlusSearchParameters();
        $params->setMaxPeptideLength($value);
        
        $this->assertEquals($value, $params->getMaxPeptideLength());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMaxPeptideLength
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidMaxPeptideLength()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setMaxPeptideLength($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMinPeptideLength
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getMinPeptideLength
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidMinPeptideLength()
    {
        $value = 65;
        
        $params = new MsgfPlusSearchParameters();
        $params->setMinPeptideLength($value);
        
        $this->assertEquals($value, $params->getMinPeptideLength());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMinPeptideLength
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidMinPeptideLength()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setMinPeptideLength($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMaxPrecursorCharge
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getMaxPrecursorCharge
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidMaxPrecursorCharge()
    {
        $value = 5;
        
        $params = new MsgfPlusSearchParameters();
        $params->setMaxPrecursorCharge($value);
        
        $this->assertEquals($value, $params->getMaxPrecursorCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMaxPrecursorCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidMaxPrecursorCharge()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setMaxPrecursorCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMinPrecursorCharge
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getMinPrecursorCharge
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidMinPrecursorCharge()
    {
        $value = 1;
        
        $params = new MsgfPlusSearchParameters();
        $params->setMinPrecursorCharge($value);
        
        $this->assertEquals($value, $params->getMinPrecursorCharge());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMinPrecursorCharge
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidMinPrecursorCharge()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setMinPrecursorCharge($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMs2DetectorId
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getMs2DetectorId
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidMs2DetectorId()
    {
        $value = 2;
        
        $params = new MsgfPlusSearchParameters();
        $params->setMs2DetectorId($value);
        
        $this->assertEquals($value, $params->getMs2DetectorId());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setMs2DetectorId
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidMs2DetectorId()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setMs2DetectorId($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setNumMatchesPerSpectrum
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getNumMatchesPerSpectrum
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidNumMatchesPerSpectrum()
    {
        $value = 1;
        
        $params = new MsgfPlusSearchParameters();
        $params->setNumMatchesPerSpectrum($value);
        
        $this->assertEquals($value, $params->getNumMatchesPerSpectrum());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setNumMatchesPerSpectrum
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidNumMatchesPerSpectrum()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setNumMatchesPerSpectrum($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setProtocolId
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getProtocolId
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidProtocolId()
    {
        $value = 3;
        
        $params = new MsgfPlusSearchParameters();
        $params->setProtocolId($value);
        
        $this->assertEquals($value, $params->getProtocolId());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setProtocolId
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidProtocolId()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setProtocolId($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setShowQValue
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getShowQValue
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidShowQValue()
    {
        $value = true;
        
        $params = new MsgfPlusSearchParameters();
        $params->setShowQValue($value);
        
        $this->assertEquals($value, $params->getShowQValue());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setShowQValue
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidShowQValue()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setShowQValue($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setTolerableTrypticTermini
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getTolerableTrypticTermini
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidTolerableTrypticTermini()
    {
        $value = 1;
        
        $params = new MsgfPlusSearchParameters();
        $params->setTolerableTrypticTermini($value);
        
        $this->assertEquals($value, $params->getTolerableTrypticTermini());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setTolerableTrypticTermini
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidTolerableTrypticTermini()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setTolerableTrypticTermini($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setNumOfThreads
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getNumOfThreads
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidNumOfThreads()
    {
        $value = 10;
        
        $params = new MsgfPlusSearchParameters();
        $params->setNumOfThreads($value);
        
        $this->assertEquals($value, $params->getNumOfThreads());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setNumOfThreads
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidNumOfThreads()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setNumOfThreads($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setAdditionalFeatures
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getAdditionalFeatures
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidAdditionalFeatures()
    {
        $value = true;
        
        $params = new MsgfPlusSearchParameters();
        $params->setAdditionalFeatures($value);
        
        $this->assertEquals($value, $params->getAdditionalFeatures());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setAdditionalFeatures
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidAdditionalFeatures()
    {
        $value = 'string';
        
        $params = new MsgfPlusSearchParameters();
        $params->setAdditionalFeatures($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setOutputFile
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getOutputFile
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidOutputFile()
    {
        $value = '/tmp/phpms_test';
        
        $params = new MsgfPlusSearchParameters();
        $params->setOutputFile($value);
        
        $this->assertEquals($value, $params->getOutputFile());
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setModificationFile
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::getModificationFile
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetValidModificationFile()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        touch($value);
        
        $params = new MsgfPlusSearchParameters();
        $params->setModificationFile($value);
        
        $this->assertEquals($value, $params->getModificationFile());
        unlink($value);
    }

    /**
     * @covers pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters::setModificationFile
     * @expectedException InvalidArgumentException
     *
     * @uses pgb_liv\php_ms\Search\Parameters\MsgfPlusSearchParameters
     */
    public function testCanGetSetInvalidModificationFile()
    {
        $value = tempnam(sys_get_temp_dir(), 'php-ms');
        unlink($value);
        
        $params = new MsgfPlusSearchParameters();
        $params->setModificationFile($value);
    }
}
