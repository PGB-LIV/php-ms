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
namespace pgb_liv\php_ms\Core\Spectra;

use pgb_liv\php_ms\Core\Identification;

/**
 * A Spectra Entry object.
 *
 * @author Andrew Collins
 */
class SpectraEntry
{

    const PROTON_MASS = 1.007276466879;

    private $mass;

    private $massCharge;

    private $charge;

    private $retentionTime;

    private $title;

    private $scans;

    private $intensity;

    private $spectra;

    private $identifications;

    /**
     * Sets the neutral mass value for this spectra
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If Mass is not a floating point value
     */
    public function setMass($mass)
    {
        if (! is_float($mass)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Received ' . gettype($mass));
        }
        
        $this->mass = $mass;
    }

    /**
     * Gets the neutral mass value for this spectra
     *
     * @return float The mass value
     */
    public function getMass()
    {
        if (is_null($this->mass)) {
            $this->mass = $this->calculateNeutralMass();
        }
        
        return $this->mass;
    }

    /**
     * Calculates the neutral mass value from the mass and charge values
     */
    private function calculateNeutralMass()
    {
        return ($this->massCharge * $this->charge) - ($this->charge * SpectraEntry::PROTON_MASS);
    }

    public function setMassCharge($mz)
    {
        if (! is_float($mz)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Value is of type ' . gettype($mz));
        }
        
        $this->massCharge = $mz;
    }

    public function getMassCharge()
    {
        return $this->massCharge;
    }

    /**
     * Sets the charge of this object
     *
     * @param int $charge
     *            The positive or negative charge to set
     * @throws \InvalidArgumentException If a non-integer value is passed
     */
    public function setCharge($charge)
    {
        if (! is_int($charge)) {
            throw new \InvalidArgumentException('Argument 1 must be of type int. Value is of type ' . gettype($charge));
        }
        
        $this->charge = $charge;
    }

    /**
     * Gets the charge value associated with this spectra
     *
     * @return int charge value
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Sets the spectra elements retention time.
     *
     * @param float $retentionTime
     *            Column retention time in seconds.
     */
    public function setRetentionTime($retentionTime)
    {
        if (! (is_int($retentionTime) || is_float($retentionTime))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($retentionTime));
        }
        
        $this->retentionTime = $retentionTime;
    }

    public function getRetentionTime()
    {
        return $this->retentionTime;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setScans($scans)
    {
        if (! (is_int($scans) || is_float($scans))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($scans));
        }
        
        $this->scans = $scans;
    }

    public function getScans()
    {
        return $this->scans;
    }

    public function setIntensity($intensity)
    {
        if (! (is_int($intensity) || is_float($intensity))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($intensity));
        }
        
        $this->intensity = $intensity;
    }

    public function getIntensity()
    {
        return $this->intensity;
    }

    public function addIon(SpectraEntry $spectra)
    {
        if (is_null($this->spectra)) {
            $this->spectra = array();
        }
        
        $this->spectra[] = $spectra;
    }

    public function getIons()
    {
        return $this->spectra;
    }

    public function addIdentification(Identification $identification)
    {
        $this->identifications[] = $identification;
    }

    /**
     * Gets the list of identifications for this spectra object
     * 
     * @return Identification[]
     */
    public function getIdentifications()
    {
        return $this->identifications;
    }
}
