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

    private $massCharge;

    private $charge;

    private $retentionTime;

    private $title;

    private $scans;

    private $intensity;

    private $spectra;

    public function setMassCharge($mz)
    {
        $this->massCharge = $mz;
    }

    public function getMassCharge()
    {
        return $this->massCharge;
    }

    public function setCharge($charge)
    {
        $this->charge = $charge;
    }

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
