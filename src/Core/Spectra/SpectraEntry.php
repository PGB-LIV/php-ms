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

/**
 * A Spectra Entry object.
 *
 * @author Andrew Collins
 */
class SpectraEntry
{

    const PROTON_MASS = 1.672621898;

    private $mass;

    private $massCharge;

    private $charge;

    private $retentionTime;

    private $title;

    private $scans;

    private $intensity;

    private $spectra;

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
        $mass = $this->massCharge * $this->charge;
        $mass -= $this->charge * SpectraEntry::PROTON_MASS;
        
        return $mass;
    }

    public function setMassCharge($mz)
    {
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
        if (! is_int($charge) > 1) {
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
        $this->scans = $scans;
    }

    public function getScans()
    {
        return $this->scans;
    }

    public function setIntensity($intensity)
    {
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
}
