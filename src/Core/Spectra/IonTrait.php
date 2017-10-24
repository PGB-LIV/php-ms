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
 * Generic trait for providing ion properties such as mass, charge and intensity
 *
 * @author Andrew Collins
 */
trait IonTrait
{

    /**
     * The Proton neutral mass value
     *
     * @var float
     */
    private static $protonMass = 1.007276466879;

    /**
     * The neutral mass value of this ion
     *
     * @var float
     */
    private $mass;

    /**
     * The mass-over-charge ratio of this ion
     *
     * @var float
     */
    private $massCharge;

    /**
     * The charge value of this ion
     *
     * @var int
     */
    private $charge;

    /**
     * The intensity value of this ion
     *
     * @var float
     */
    private $intensity;

    /**
     * Sets the neutral mass value for this ion
     *
     * @param float $mass
     *            Mass value expressed as a floating point value
     * @throws \InvalidArgumentException If mass is not a floating point value
     */
    public function setMass($mass)
    {
        if (! is_float($mass)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Received ' . gettype($mass));
        }
        
        $this->mass = $mass;
    }

    /**
     * Gets the neutral mass value for this ion
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
     * Sets the mass-to-charge ratio for this ion
     *
     * @param float $massCharge
     *            The mass-to-charge ratio to set to
     * @throws \InvalidArgumentException If $mz is not a valid floating point value
     */
    public function setMassCharge($massCharge)
    {
        if (! is_float($massCharge)) {
            throw new \InvalidArgumentException('Argument 1 must be of type float. Value is of type ' . gettype($massCharge));
        }
        
        $this->massCharge = $massCharge;
    }

    /**
     * Gets the mass-to-charge ratio for this ion
     *
     * @return float
     */
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
     * Calculates the neutral mass value from the mass and charge values
     */
    private function calculateNeutralMass()
    {
        return ($this->massCharge * $this->charge) - ($this->charge * self::$protonMass);
    }
}
