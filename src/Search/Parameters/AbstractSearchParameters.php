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

use pgb_liv\php_ms\Core\Tolerance;
use pgb_liv\php_ms\Core\Modification;

/**
 * Abstract class containing generic filtering methods
 *
 * @author Andrew Collins
 */
abstract class AbstractSearchParameters
{

    private $databases;

    private $spectraPath;

    private $precursorTolerance;

    private $fragmentTolerance;

    private $enzyme;

    private $isDecoyEnabled = 0;

    private $missedCleavageCount;

    private $modifications = array();

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
        if (! is_int($maxCleave) || $maxCleave < 0) {
            throw new \InvalidArgumentException('Argument 1 must be an unsigned integer value');
        }
        
        $this->missedCleavageCount = $maxCleave;
    }

    public function getMissedCleavageCount()
    {
        return $this->missedCleavageCount;
    }

    public function getPrecursorTolerance()
    {
        return $this->precursorTolerance;
    }

    public function setPrecursorTolerance(Tolerance $tolerance)
    {
        $this->precursorTolerance = $tolerance;
    }

    public function setFragmentTolerance(Tolerance $tolerance)
    {
        $this->fragmentTolerance = $tolerance;
    }

    /**
     * Gets the Fragment Tolerance object
     *
     * @return \pgb_liv\php_ms\Core\Tolerance
     */
    public function getFragmentTolerance()
    {
        return $this->fragmentTolerance;
    }

    /**
     * Sets the spectra file location
     *
     * @param string $filePath
     *            Path to the spectra file
     * @param bool $ignoreValidation
     *            If true will disable validation that the file must exist
     * @throws \InvalidArgumentException Thrown if $ignoreValidation is false and the file does not exist
     */
    public function setSpectraPath($filePath, $ignoreValidation = false)
    {
        if (! $ignoreValidation && ! file_exists($filePath)) {
            throw new \InvalidArgumentException('Argument 1 must specify a valid file');
        }
        
        $this->spectraPath = $filePath;
    }

    public function getSpectraPath()
    {
        return $this->spectraPath;
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

    public function addModification(Modification $modification)
    {
        $this->modifications[] = $modification;
    }

    /**
     *
     * @return Modification[]
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    public function clearModifications()
    {
        $this->modifications = array();
    }

    public function addFixedModification(Modification $modification)
    {
        $modification->setType(Modification::TYPE_FIXED);
        $this->addModification($modification);
    }

    public function getFixedModifications()
    {
        $fixed = array();
        foreach ($this->getModifications() as $modification) {
            if ($modification->getType() == Modification::TYPE_FIXED) {
                $fixed[] = $modification;
            }
        }
        
        return $fixed;
    }

    public function addVariableModification(Modification $modification)
    {
        $modification->setType(Modification::TYPE_VARIABLE);
        $this->addModification($modification);
    }

    public function getVariableModifications()
    {
        $variable = array();
        foreach ($this->getModifications() as $modification) {
            if ($modification->getType() == Modification::TYPE_VARIABLE) {
                $variable[] = $modification;
            }
        }
        
        return $variable;
    }
}
