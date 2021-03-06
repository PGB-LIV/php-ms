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

/**
 * Interface to ion properties of an object
 *
 * @author Andrew Collins
 */
interface IonInterface
{

    const RETENTION_TIME_START = 0;

    const RETENTION_TIME_END = 1;
    
    /**
     * Sets the neutral mass value for this ion
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If mass is not a floating point value
     */
    public function setMonoisotopicMass($mass);
    
    /**
     * Gets the neutral mass value for this ion
     *
     * @return float The mass value
     */
    public function getMonoisotopicMass();
    
    /**
     * Sets the mass-to-charge ratio for this ion
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setMonoisotopicMassCharge($massCharge, $charge);
    
    /**
     * Gets the mass-to-charge ratio for this ion
     *
     * @return float
     */
    public function getAverageMassCharge();
    
    /**
     * Sets the neutral mass value for this ion
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If mass is not a floating point value
     */
    public function setAverageMass($mass);
    
    /**
     * Gets the neutral mass value for this ion
     *
     * @return float The mass value
     */
    public function getAverageMass();
    
    /**
     * Sets the mass-to-charge ratio for this ion
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setAverageMassCharge($massCharge, $charge);
    
    /**
     * Gets the mass-to-charge ratio for this ion
     *
     * @return float
     */
    public function getMonoisotopicMassCharge();

    /**
     * Gets the charge value associated with this spectra
     *
     * @return int charge value
     */
    public function getCharge();

    /**
     * Sets the intensity value for this ion
     *
     * @param float $intensity
     *            The intensity value to set
     * @throws \InvalidArgumentException If the intensity is not of type float
     */
    public function setIntensity($intensity);

    /**
     * Gets the intensity value for this object
     *
     * @return float
     */
    public function getIntensity();

    /**
     * Sets the spectra elements retention time
     *
     * @param float $retentionTime
     *            Retention time of fragment
     */
    public function setRetentionTime($retentionTime);

    /**
     * Sets the spectra elements retention time or retention time window
     *
     * @param float $retentionTimeStart
     *            Retention time of fragment or start of retention time window
     * @param float $retentionTimeEnd
     *            End of retention time window, or null if equal to start
     */
    public function setRetentionTimeWindow($retentionTimeStart, $retentionTimeEnd);

    /**
     * Gets the retention time in seconds, or the average if a window has been set
     *
     * @return float
     */
    public function getRetentionTime();

    /**
     * Gets the retention time window in seconds
     *
     * @return array
     */
    public function getRetentionTimeWindow();

    /**
     * Returns true if the retention time is a window
     *
     * @return boolean
     */
    public function hasRetentionTimeWindow();
}
