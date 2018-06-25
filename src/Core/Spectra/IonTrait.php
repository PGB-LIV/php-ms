<?php
/**
 * Copyright 2018 University of Liverpool
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

use pgb_liv\php_ms\Core\ChargedMassTrait;

/**
 * Generic trait for providing ion properties such as mass, charge and intensity
 *
 * @todo Add support for Scan/Scan Range
 * @author Andrew Collins
 */
trait IonTrait
{
    use ChargedMassTrait;

    /**
     * The intensity value of this ion
     *
     * @var float
     */
    private $intensity;

    /**
     * The retention time window for this object
     *
     * @var array
     */
    private $retentionTimeWindow;

    /**
     * Sets the monoisotopic neutral mass value for this ion
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If mass is not a floating point value
     * @deprecated Use setMonoisotpicMass()
     */
    public function setMass($mass)
    {
        $this->setMonoisotopicMass($mass);
    }

    /**
     * Gets the monoisotopic neutral mass value for this ion
     *
     * @return float The mass value
     * @deprecated Use getMonoisotpicMass()
     */
    public function getMass()
    {
        return $this->getMonoisotopicMass();
    }

    /**
     * Sets the intensity value for this ion
     *
     * @param float $intensity
     *            The intensity value to set
     * @throws \InvalidArgumentException If the intensity is not of type float
     */
    public function setIntensity($intensity)
    {
        if (! (is_int($intensity) || is_float($intensity))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($intensity));
        }
        
        $this->intensity = $intensity;
    }

    /**
     * Gets the intensity value for this object
     *
     * @return float
     */
    public function getIntensity()
    {
        return $this->intensity;
    }

    /**
     * Sets the spectra elements retention time
     *
     * @param float $retentionTime
     *            Retention time of fragment
     */
    public function setRetentionTime($retentionTime)
    {
        if (! (is_int($retentionTime) || is_float($retentionTime))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($retentionTime));
        }
        
        $this->retentionTimeWindow = $retentionTime;
    }

    /**
     * Sets the spectra elements retention time or retention time window
     *
     * @param float $retentionTimeStart
     *            Retention time of fragment or start of retention time window
     * @param float $retentionTimeEnd
     *            End of retention time window, or null if equal to start
     */
    public function setRetentionTimeWindow($retentionTimeStart, $retentionTimeEnd)
    {
        if (! (is_int($retentionTimeStart) || is_float($retentionTimeStart))) {
            throw new \InvalidArgumentException(
                'Argument 1 must be of type int or float. Value is of type ' . gettype($retentionTimeStart));
        }
        
        if (! (is_int($retentionTimeEnd) || is_float($retentionTimeEnd))) {
            throw new \InvalidArgumentException(
                'Argument 2 must be of type int or float. Value is of type ' . gettype($retentionTimeEnd));
        }
        
        $this->retentionTimeWindow = array();
        $this->retentionTimeWindow[static::RETENTION_TIME_START] = $retentionTimeStart;
        $this->retentionTimeWindow[static::RETENTION_TIME_END] = $retentionTimeEnd;
    }

    /**
     * Gets the retention time in seconds, or the average if a window has been set
     *
     * @return float
     */
    public function getRetentionTime()
    {
        if (is_array($this->retentionTimeWindow)) {
            return ($this->retentionTimeWindow[static::RETENTION_TIME_START] +
                $this->retentionTimeWindow[static::RETENTION_TIME_END]) / 2;
        }
        
        return $this->retentionTimeWindow;
    }

    /**
     * Gets the retention time window in seconds
     *
     * @return array
     */
    public function getRetentionTimeWindow()
    {
        if (is_array($this->retentionTimeWindow)) {
            return $this->retentionTimeWindow;
        }
        
        return array(
            $this->retentionTimeWindow,
            $this->retentionTimeWindow
        );
    }

    /**
     * Returns true if the retention time is a window
     *
     * @return boolean
     */
    public function hasRetentionTimeWindow()
    {
        return is_array($this->retentionTimeWindow);
    }
}
