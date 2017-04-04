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
namespace pgb_liv\php_ms\Search\Parameters;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractSearchParameters
{

    private $databases;

    private $spectraPath;

    private $precursorToleranceValue;

    private $precursorToleranceUnit;

    private $fragmentToleranceValue;

    private $fragmentToleranceUnit;

    private $enzyme;

    private $isDecoyEnabled = 0;

    private $missedCleavageCount;

    public function setDatabases($databases)
    {
        $this->databases = $databases;
    }

    /**
     * The sequence database(s) to be searched.
     *
     * @return string
     */
    public function getDatabases()
    {
        return $this->databases;
    }

    public function setEnzyme($enzyme)
    {
        $this->enzyme = $enzyme;
    }

    public function getEnzyme()
    {
        return $this->enzyme;
    }

    public function setMissedCleavageCount($maxCleave)
    {
        if (! is_int($maxCleave) || $maxCleave < 0 || $maxCleave > 9) {
            throw new \InvalidArgumentException('Argument 1 must be an integer value between 0 and 9');
        }
        
        $this->missedCleavageCount = $maxCleave;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function setPrecursorTolerance($precursorTolerance)
    {
        if ((! is_float($precursorTolerance) && ! is_int($precursorTolerance)) || $precursorTolerance < 0) {
            throw new \InvalidArgumentException('Argument 1 must be a float or integer value greater than 0');
        }
        
        $this->precursorTolerance = $precursorTolerance;
    }

    public function getPrecursorTolerance()
    {
        return $this->precursorTolerance;
    }

    public function setPrecursorToleranceUnit($unit)
    {
        // TODO: Validate unit
        $this->precursorToleranceUnit = $unit;
    }

    public function getPrecursorToleranceUnit()
    {
        return $this->precursorToleranceUnit;
    }

    public function setFragmentTolerance($fragmentTolerance)
    {
        if ((! is_float($fragmentTolerance) && ! is_int($fragmentTolerance)) || $fragmentTolerance < 0) {
            throw new \InvalidArgumentException('Argument 1 must be a float or integer value greater than 0');
        }
        
        $this->fragmentTolerance = $fragmentTolerance;
    }

    public function getFragmentTolerance()
    {
        return $this->fragmentTolerance;
    }

    public function setFragmentToleranceUnit($fragmentToleranceUnit)
    {
        // TODO: Validate unit
        $this->fragmentToleranceUnit = $fragmentToleranceUnit;
    }

    public function getFragmentToleranceUnit()
    {
        return $this->fragmentToleranceUnit;
    }

    public function setSpectraPath($filePath)
    {
        if (! file_exists($filePath)) {
            throw new \InvalidArgumentException('Argument 1 must specify a valid file');
        }
        
        $this->file = $filePath;
    }

    public function getSpectraPath()
    {
        return $this->file;
    }

    public function setDecoyEnabled($bool)
    {
        if (! is_bool($bool)) {
            throw new \InvalidArgumentException('Argument 1 must be a boolean value');
        }
        
        $this->isDecoyEnabled = $bool;
    }

    public function isDecoyEnabled()
    {
        return $this->isDecoyEnabled;
    }
}
