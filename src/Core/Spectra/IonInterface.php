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
 * Interface to ion properties of an object
 *
 * @author Andrew Collins
 */
interface IonInterface
{

    /**
     * Sets the neutral mass value for this ion
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If mass is not a floating point value
     */
    public function setMass($mass);

    /**
     * Gets the neutral mass value for this ion
     *
     * @return float The mass value
     */
    public function getMass();

    /**
     * Sets the mass-to-charge ratio for this ion
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setMassCharge($massCharge);

    /**
     * Gets the mass-to-charge ratio for this ion
     *
     * @return float
     */
    public function getMassCharge();

    /**
     * Sets the charge of this object
     *
     * @param int $charge
     *            The positive or negative charge to set
     * @throws \InvalidArgumentException If a non-integer value is passed
     */
    public function setCharge($charge);

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
}
